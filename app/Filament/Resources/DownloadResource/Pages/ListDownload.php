<?php

namespace App\Filament\Resources\DownloadResource\Pages;

use App\Filament\Resources\DownloadResource;
use Filament\Resources\Pages\ListRecords;

class ListDownload extends ListRecords
{
    protected static string $resource = DownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
