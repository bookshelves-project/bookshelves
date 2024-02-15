<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Kiwilan\Steward\Filament\Config\FilamentChart;

class DownloadsChart extends ChartWidget
{
    protected static ?string $heading = 'Downloads per month';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return FilamentChart::statsByMonth('downloads')
            ->label('Downloads')
            ->get();
    }
}
