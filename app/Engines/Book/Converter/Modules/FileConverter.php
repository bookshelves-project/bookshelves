<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\MediaDiskEnum;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Enums\SpatieMediaMethodEnum;
use Kiwilan\Steward\Services\MediaService;
use Kiwilan\Steward\Utils\Console;

class FileConverter
{
    public const DISK = MediaDiskEnum::format;

    /**
     * Generate new file with standard name.
     * Managed by spatie/laravel-medialibrary.
     */
    public static function make(Ebook $ebook, Book $book): void
    {
        // $extension = pathinfo($converter->parser_engine->file_path, PATHINFO_EXTENSION);

        $fileName = Str::slug("{$book->meta_author}_{$book->slug_sort}_{$book->language_slug}");

        // $result = false;

        // if (pathinfo($converter->parser_engine->file_path, PATHINFO_BASENAME) !== $file_name) {
        //     try {

        //         $result = true;
        //     } catch (\Throwable $th) {
        //         $console = Console::make();
        //         $console->print(__METHOD__, 'red', $th);
        //         $console->newLine();
        //     }
        // }
        $file = File::get($ebook->path());

        MediaService::make(
            model: $book,
            name: $fileName,
            disk: self::DISK,
            collection: $ebook->format(),
            extension: $ebook->extension(),
            method: SpatieMediaMethodEnum::addMediaFromString
        )
            ->setMedia($file)
        ;
    }
}
