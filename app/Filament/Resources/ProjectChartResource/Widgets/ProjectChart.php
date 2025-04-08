<?php

namespace App\Filament\Resources\ProjectChartResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Project;

class ProjectChart extends ChartWidget
{
    protected static ?string $heading = 'Proyectos por Estado';

    protected function getData(): array
    {

        $completed = Project::where('status', 'completed')->count();
        $inProgress = Project::where('status', 'in_progress')->count();
        $pending = Project::where('status', 'active')->count();

        return [
            'labels' => ['Completados', 'En Progreso', 'Pendientes'],
            'datasets' => [
                [
                    'label' => 'Proyectos por Estado',
                    'data' => [$completed, $inProgress, $pending],
                    'backgroundColor' => ['#4CAF50', '#FF9800', '#2196F3'],
                    'borderColor' => ['#388E3C', '#FF5722', '#1976D2'],
                    'borderWidth' => 1,
                ]
            ]
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
