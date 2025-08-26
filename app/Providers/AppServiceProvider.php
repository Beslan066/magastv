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

            // Получаем TV программы на сегодня
            $tvProgramsRaw = TvShow::whereDate('program_date', $today)->get();

            $tvActive = null;
            $tvUpcoming = [];

            foreach ($tvProgramsRaw as $program) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                $endTime = trim($timeParts[1] ?? $startTime);

                // Создаем время с указанием часового пояса
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

                // Проверяем, идет ли программа сейчас
                if ($now->between($start, $end)) {
                    $tvActive = $program;
                }
                // Проверяем, будет ли программа в будущем
                elseif ($start->isFuture()) {
                    $tvUpcoming[] = $program;
                }
            }

            // Сортируем upcoming программы по времени начала
            $tvUpcoming = collect($tvUpcoming)->sortBy(function($program) use ($timezone) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                return Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime,
                    $timezone
                );
            })->values();

            // Формируем итоговый список
            $tvProgramsToday = collect();
            if ($tvActive) {
                $tvProgramsToday->push($tvActive);
            }
            $tvProgramsToday = $tvProgramsToday->merge($tvUpcoming);

            // Получаем Radio программы на сегодня
            $radioProgramsRaw = RadioShow::whereDate('program_date', $today)->get();

            $radioActive = null;
            $radioUpcoming = [];

            foreach ($radioProgramsRaw as $program) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                $endTime = trim($timeParts[1] ?? $startTime);

                // Создаем время с указанием часового пояса
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

                // Проверяем, идет ли программа сейчас
                if ($now->between($start, $end)) {
                    $radioActive = $program;
                }
                // Проверяем, будет ли программа в будущем
                elseif ($start->isFuture()) {
                    $radioUpcoming[] = $program;
                }
            }

            // Сортируем upcoming программы по времени начала
            $radioUpcoming = collect($radioUpcoming)->sortBy(function($program) use ($timezone) {
                $timeParts = explode('-', $program->time_range);
                $startTime = trim($timeParts[0]);
                return Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $program->program_date->format('Y-m-d') . ' ' . $startTime,
                    $timezone
                );
            })->values();

            // Формируем итоговый список
            $radioProgramsToday = collect();
            if ($radioActive) {
                $radioProgramsToday->push($radioActive);
            }
            $radioProgramsToday = $radioProgramsToday->merge($radioUpcoming);

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
