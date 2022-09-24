<?php

namespace App\Filament\Widgets;

use App\Filament\ChartHelper;
use Filament\Widgets\LineChartWidget;

class ReferencesChart extends LineChartWidget
{
    protected static ?string $heading = 'Réalisations sur 20 ans';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $references = ChartHelper::getStatsByYear();

        return [
            'datasets' => [
                [
                    'label' => 'Réalisations',
                    'data' => $references->stats,
                    // 'borderColor' => '#F8B427',
                ],
            ],
            'labels' => $references->labels,
        ];
    }
}
