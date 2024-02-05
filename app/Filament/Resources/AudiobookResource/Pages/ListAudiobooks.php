<?php

namespace App\Filament\Resources\AudiobookResource\Pages;

use App\Filament\Resources\AudiobookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudiobooks extends ListRecords
{
    protected static string $resource = AudiobookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
