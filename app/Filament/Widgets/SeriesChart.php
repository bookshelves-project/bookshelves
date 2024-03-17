<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Kiwilan\Steward\Filament\Config\FilamentChart;

class SeriesChart extends ChartWidget
{
    protected static ?string $heading = 'Series per month';

    protected static ?int $sort = 1;

    protected static string $color = 'info';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return FilamentChart::statsByMonth('series')
            ->label('Series')
            ->field('updated_at')
            ->get();
    }
}
