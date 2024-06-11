<?php

namespace App\Filament\Resources\AudiobookTrackResource\Pages;

use App\Filament\Resources\AudiobookTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAudiobookTrack extends EditRecord
{
    protected static string $resource = AudiobookTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
