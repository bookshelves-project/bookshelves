<?php

namespace App\Filament\Resources\Books\SerieResource\Pages;

use App\Filament\Resources\Books\SerieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeries extends ListRecords
{
    // use ListRecords\Concerns\Translatable;

    protected static string $resource = SerieResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
