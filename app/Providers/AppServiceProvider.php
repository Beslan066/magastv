<?php

namespace App\Providers;

use App\Models\RadioShow;
use App\Models\TvShow;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

            $tvProgramsRaw = TvShow::whereDate('program_date', $today)->get();

            $tvActive = null;
            $tvUpcoming = [];

            foreach ($tvProgramsRaw as $program) {
                $start = Carbon::createFromFormat('Y-m-d H:i', $program->program_date->format('Y-m-d') . ' ' . explode('-', $program->time_range)[0]);
                $end = Carbon::createFromFormat('Y-m-d H:i', $program->program_date->format('Y-m-d') . ' ' . explode('-', $program->time_range)[1]);

                if ($now->between($start, $end)) {
                    $tvActive = $program;
                } elseif ($end->isFuture()) {
                    $tvUpcoming[] = $program;
                }
            }

            // Соберём окончательный список: сначала active, потом будущие
            $tvProgramsToday = collect(array_filter([$tvActive]))
                ->merge($tvUpcoming)
                ->sortBy(function ($program) {
                    $start = Carbon::createFromFormat('H:i', explode('-', $program->time_range)[0]);
                    return $start;
                })
                ->values();

            // То же для radio
            $radioProgramsRaw = RadioShow::whereDate('program_date', $today)->get();
            $radioActive = null;
            $radioUpcoming = [];

            foreach ($radioProgramsRaw as $program) {
                $start = Carbon::createFromFormat('Y-m-d H:i', $program->program_date->format('Y-m-d') . ' ' . explode('-', $program->time_range)[0]);
                $end = Carbon::createFromFormat('Y-m-d H:i', $program->program_date->format('Y-m-d') . ' ' . explode('-', $program->time_range)[1]);

                if ($now->between($start, $end)) {
                    $radioActive = $program;
                } elseif ($end->isFuture()) {
                    $radioUpcoming[] = $program;
                }
            }

            $radioProgramsToday = collect(array_filter([$radioActive]))
                ->merge($radioUpcoming)
                ->sortBy(function ($program) {
                    $start = Carbon::createFromFormat('H:i', explode('-', $program->time_range)[0]);
                    return $start;
                })
                ->values();

            $view->with([
                'tvProgramsToday' => $tvProgramsToday,
                'radioProgramsToday' => $radioProgramsToday,
            ]);
        });
    }
}
