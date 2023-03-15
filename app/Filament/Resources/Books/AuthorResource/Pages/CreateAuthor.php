<?php

namespace App\Filament\Resources\Books\AuthorResource\Pages;

use App\Filament\Resources\Books\AuthorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;
}
