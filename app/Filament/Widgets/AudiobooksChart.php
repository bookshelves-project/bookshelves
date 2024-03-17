<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Kiwilan\Steward\Filament\Config\FilamentChart;

class AudiobooksChart extends ChartWidget
{
    protected static ?string $heading = 'Audiobooks per month';

    protected static ?int $sort = 1;

    protected static string $color = 'danger';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return FilamentChart::statsByMonth('audiobooks')
            ->label('Audiobooks')
            ->field('added_at')
            ->get();
    }
}
