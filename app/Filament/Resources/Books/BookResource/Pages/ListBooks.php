<?php

namespace App\Filament\Resources\Books\BookResource\Pages;

use App\Filament\Resources\Books\BookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getTableRecordsPerPageSelectOptions(): array
    // {
    //     return [25, 50, 100];
    // }
}
