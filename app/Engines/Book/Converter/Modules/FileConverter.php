<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\MediaDiskEnum;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Enums\SpatieMediaMethodEnum;
use Kiwilan\Steward\Services\MediaService;

class FileConverter
{
    public const DISK = MediaDiskEnum::format;

    /**
     * Generate new file with standard name.
     * Managed by spatie/laravel-medialibrary.
     */
    public static function make(Ebook $ebook, Book $book): void
    {
        $author = $book->authors->first()?->name ?? 'Unknown';
        $fileName = Str::slug("{$author}_{$book->slug_sort}_{$book->language_slug}");
        $file = File::get($ebook->getPath());

        MediaService::make(
            model: $book,
            name: $fileName,
            disk: self::DISK,
            collection: $ebook->getFormat()->value,
            extension: $ebook->getExtension(),
            method: SpatieMediaMethodEnum::addMediaFromString
        )
            ->setMedia($file);
    }
}
