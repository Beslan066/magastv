<?php

namespace App\Providers;

use App\Models\RadioShow;
use App\Models\TvShow;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Carbon\Carbon::setLocale('ru');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.frontend', 'frontend.live.live'], function ($view) {
            $timezone = 'Europe/Moscow';
            $now = Carbon::now($timezone);
            $today = $now->format('Y-m-d');

            // TV программы на сегодня
            $tvProgramsToday = TvShow::with('age_restriction')
                ->whereDate('program_date', $today)
                ->get()
                ->filter(function($program) use ($now) {
                    // Исключаем прошедшие передачи (которые уже закончились)
                    // Теперь end_time правильно учитывает переход через полночь
                    return $program->end_time->gt($now);
                })
                ->sortBy('start_time');

            // Находим активную передачу (только одну!)
            $currentTvProgram = $tvProgramsToday->first(function($program) use ($now) {
                return $now->between($program->start_time, $program->end_time);
            });

            // Radio программы на сегодня
            $radioProgramsToday = RadioShow::with('age_restriction')
                ->whereDate('program_date', $today)
                ->get()
                ->filter(function($program) use ($now) {
                    return $program->end_time->gt($now);
                })
                ->sortBy('start_time');

            $currentRadioProgram = $radioProgramsToday->first(function($program) use ($now) {
                return $now->between($program->start_time, $program->end_time);
            });

            $view->with([
                'tvProgramsToday' => $tvProgramsToday,
                'radioProgramsToday' => $radioProgramsToday,
                'currentTvProgram' => $currentTvProgram,
                'currentRadioProgram' => $currentRadioProgram,
            ]);
        });

        Paginator::useBootstrapFive();
    }
}
