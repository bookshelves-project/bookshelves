<?php

namespace App\Filament\Resources\Content\ContentResource\Pages;

use App\Filament\Resources\Content\ContentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContent extends EditRecord
{
    protected static string $resource = ContentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
