<?php

namespace App\Filament\Resources\Creation\ReferenceResource\Widgets;

use App\Enums\PublishStatusEnum;
use App\Models\Reference;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ReferenceStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total des articles', Reference::count()),
            Card::make('Publiés', Reference::where('status', PublishStatusEnum::published)->count()),
        ];
    }
}
