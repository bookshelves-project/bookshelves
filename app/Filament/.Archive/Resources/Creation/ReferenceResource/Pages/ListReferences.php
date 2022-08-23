<?php

namespace App\Filament\Resources\Creation\ReferenceResource\Pages;

use App\Filament\Resources\Creation\ReferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferences extends ListRecords
{
    protected static string $resource = ReferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ReferenceResource::getWidgets();
    }
}
