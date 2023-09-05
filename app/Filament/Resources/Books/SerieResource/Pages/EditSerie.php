<?php

namespace App\Filament\Resources\Books\SerieResource\Pages;

use App\Filament\Resources\Books\SerieResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSerie extends EditRecord
{
    // use EditRecord\Concerns\Translatable;

    protected static string $resource = SerieResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
