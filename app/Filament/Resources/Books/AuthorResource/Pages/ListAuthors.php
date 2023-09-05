<?php

namespace App\Filament\Resources\Books\AuthorResource\Pages;

use App\Filament\Resources\Books\AuthorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
