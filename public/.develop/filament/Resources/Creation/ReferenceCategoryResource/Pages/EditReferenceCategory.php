<?php

namespace App\Filament\Resources\Creation\ReferenceCategoryResource\Pages;

use App\Filament\Resources\Creation\ReferenceCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferenceCategory extends EditRecord
{
    protected static string $resource = ReferenceCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
