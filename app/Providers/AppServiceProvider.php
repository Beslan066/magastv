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
        View::composer('layouts.frontend', function ($view) {
            $today = Carbon::now('Europe/Moscow')->toDateString();
            $now = Carbon::now('Europe/Moscow');

            // Получаем TV программы на сегодня и сортируем по времени начала
            $tvProgramsToday = TvShow::whereDate('program_date', $today)
                ->get()
                ->sortBy(function($program) {
                    $timeParts = explode('-', $program->time_range);
                    return trim($timeParts[0]);
                });

            $tvActive = null;
            $tvUpcoming = [];

            foreach ($tvProgramsToday as $program) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                $endTime = trim($timeParts[1] ?? $startTime);

                $start = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime
                );

                $end = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $endTime
                );

                if ($now->between($start, $end)) {
                    $tvActive = $program;
                } elseif ($start->isFuture()) {
                    $tvUpcoming[] = $program;
                }
            }

            // Формируем итоговый список TV программ
            $tvProgramsList = collect();
            if ($tvActive) {
                $tvProgramsList->push($tvActive);
            }
            $tvProgramsList = $tvProgramsList->merge($tvUpcoming);

            // Получаем Radio программы на сегодня и сортируем по времени начала
            $radioProgramsToday = RadioShow::whereDate('program_date', $today)
                ->get()
                ->sortBy(function($program) {
                    $timeParts = explode('-', $program->time_range);
                    return trim($timeParts[0]);
                });

            $radioActive = null;
            $radioUpcoming = [];

            foreach ($radioProgramsToday as $program) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                $endTime = trim($timeParts[1] ?? $startTime);

                $start = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime
                );

                $end = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $endTime
                );

                if ($now->between($start, $end)) {
                    $radioActive = $program;
                } elseif ($start->isFuture()) {
                    $radioUpcoming[] = $program;
                }
            }

            // Формируем итоговый список Radio программ
            $radioProgramsList = collect();
            if ($radioActive) {
                $radioProgramsList->push($radioActive);
            }
            $radioProgramsList = $radioProgramsList->merge($radioUpcoming);

            $view->with([
                'tvProgramsToday' => $tvProgramsList,
                'radioProgramsToday' => $radioProgramsList,
                'currentTvProgram' => $tvActive,
                'currentRadioProgram' => $radioActive,
            ]);
        });

        Paginator::useBootstrapFive();
    }
}
