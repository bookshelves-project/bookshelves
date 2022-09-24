<?php

namespace App\Filament\Resources\Blog\TagResource\Pages;

use App\Filament\Resources\Blog\TagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;
}
