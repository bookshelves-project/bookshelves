<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\MediaDiskEnum;
use App\Enums\SpatieMediaMethodEnum;
use App\Models\Book;
use App\Services\ConsoleService;
use App\Services\MediaService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TypeConverter
{
    public const DISK = MediaDiskEnum::format;

    /**
     * Generate new file with standard name.
     * Managed by spatie/laravel-medialibrary.
     */
    public static function convert(ParserEngine $parser, Book $book): bool
    {
        $extension = pathinfo($parser->file_path, PATHINFO_EXTENSION);

        $author = $book->meta_author;
        $serie = $book->slug_sort;
        $language = $book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;
        if (pathinfo($parser->file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($parser->file_path);
                MediaService::create(
                    model: $book,
                    name: $file_name,
                    disk: self::DISK,
                    collection: $parser->format->value,
                    extension: $extension,
                    method: SpatieMediaMethodEnum::addMediaFromString
                )->setMedia($file);
                $result = true;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, 'red', $th);
                ConsoleService::newLine();
            }
        }

        return $result;
    }
}
