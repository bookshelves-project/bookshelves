<?php

namespace App\Filament\Resources\AudiobookResource\Pages;

use App\Filament\Resources\AudiobookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAudiobook extends EditRecord
{
    protected static string $resource = AudiobookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
