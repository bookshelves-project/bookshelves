<?php

namespace App\Filament\Widgets;

use App\Filament\ChartHelper;
use Filament\Widgets\LineChartWidget;

class PostsChart extends LineChartWidget
{
    protected static ?string $heading = 'Articles par mois (année actuelle)';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $posts = ChartHelper::getStatsByMonth(date('Y'));

        return [
            'datasets' => [
                [
                    'label' => 'Articles',
                    'data' => $posts,
                    // 'borderColor' => '#595AD4',
                ],
            ],
            'labels' => ['Janv.', 'Fevr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Dec.'],
        ];
    }
}
