<?php

namespace App\Filament\Resources\Books\SerieResource\Pages;

use App\Filament\Resources\Books\SerieResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSerie extends CreateRecord
{
    protected static string $resource = SerieResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }
}
