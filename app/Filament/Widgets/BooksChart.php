<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Kiwilan\Steward\Filament\Config\FilamentChart;

class BooksChart extends ChartWidget
{
    protected static ?string $heading = 'Books per month';

    protected static ?int $sort = 1;

    protected static string $color = 'success';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return FilamentChart::statsByMonth('books')
            ->label('Books')
            ->field('added_at')
            ->get();
    }
}
