<?php

namespace App\Filament\Resources\AudiobookTrackResource\Pages;

use App\Filament\Resources\AudiobookTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudiobookTracks extends ListRecords
{
    protected static string $resource = AudiobookTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
