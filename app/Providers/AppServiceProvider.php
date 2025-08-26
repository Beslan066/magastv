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
            $timezone = 'Europe/Moscow';
            $today = Carbon::now($timezone)->toDateString();
            $now = Carbon::now($timezone);

            // TV программы
            $tvProgramsRaw = TvShow::with('age_restriction')
                ->whereDate('program_date', $today)
                ->get();

            $tvActive = null;
            $tvUpcoming = [];

            foreach ($tvProgramsRaw as $program) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                $endTime = trim($timeParts[1] ?? $startTime);

                $start = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime,
                    $timezone
                );

                $end = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $endTime,
                    $timezone
                );

                if ($now->between($start, $end)) {
                    $tvActive = $program;
                } elseif ($start->isFuture()) {
                    $tvUpcoming[] = $program;
                }
            }

            // Сортируем upcoming по времени начала
            $tvUpcoming = collect($tvUpcoming)->sortBy(function($program) use ($timezone) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                return Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime,
                    $timezone
                );
            });

            $tvProgramsToday = $tvActive ? collect([$tvActive])->merge($tvUpcoming) : $tvUpcoming;

            // Radio программы
            $radioProgramsRaw = RadioShow::with('age_restriction')
                ->whereDate('program_date', $today)
                ->get();

            $radioActive = null;
            $radioUpcoming = [];

            foreach ($radioProgramsRaw as $program) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                $endTime = trim($timeParts[1] ?? $startTime);

                $start = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime,
                    $timezone
                );

                $end = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $endTime,
                    $timezone
                );

                if ($now->between($start, $end)) {
                    $radioActive = $program;
                } elseif ($start->isFuture()) {
                    $radioUpcoming[] = $program;
                }
            }

            $radioUpcoming = collect($radioUpcoming)->sortBy(function($program) use ($timezone) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                return Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime,
                    $timezone
                );
            });

            $radioProgramsToday = $radioActive ? collect([$radioActive])->merge($radioUpcoming) : $radioUpcoming;

            $view->with([
                'tvProgramsToday' => $tvProgramsToday,
                'radioProgramsToday' => $radioProgramsToday,
                'currentTvProgram' => $tvActive,
                'currentRadioProgram' => $radioActive,
            ]);
        });

        Paginator::useBootstrapFive();
    }
}
