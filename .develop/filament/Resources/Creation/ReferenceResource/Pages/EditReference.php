<?php

namespace App\Filament\Resources\Creation\ReferenceResource\Pages;

use App\Filament\Resources\Creation\ReferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReference extends EditRecord
{
    protected static string $resource = ReferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
