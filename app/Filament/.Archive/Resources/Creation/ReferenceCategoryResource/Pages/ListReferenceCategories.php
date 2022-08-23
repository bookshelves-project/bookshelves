<?php

namespace App\Filament\Resources\Creation\ReferenceCategoryResource\Pages;

use App\Filament\Resources\Creation\ReferenceCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferenceCategories extends ListRecords
{
    protected static string $resource = ReferenceCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
