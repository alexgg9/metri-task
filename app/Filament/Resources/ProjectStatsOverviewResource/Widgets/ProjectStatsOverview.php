<?php

namespace App\Filament\Resources\ProjectStatsOverviewResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;
use App\Models\Task;


class ProjectStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Proyectos totales', Project::count())
                ->description('Todos los proyectos creados')
                ->color('primary'),

            Stat::make('Tareas completadas', Task::where('status', 'completed')->count())
                ->description('Tareas que ya se han completado')
                ->color('success'),

            Stat::make('Tareas pendientes', Task::where('status', 'pending')->count())
                ->description('Aún por hacer')
                ->color('warning'),
        ];
    }
}
