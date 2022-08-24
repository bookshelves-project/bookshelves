<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Enums\MediaDiskEnum;
use App\Enums\SpatieMediaMethodEnum;
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
    public static function create(ConverterEngine $converter): bool
    {
        $extension = pathinfo($converter->parser->file_path, PATHINFO_EXTENSION);

        $author = $converter->book->meta_author;
        $serie = $converter->book->slug_sort;
        $language = $converter->book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;
        if (pathinfo($converter->parser->file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($converter->parser->file_path);
                MediaService::create(
                    model: $converter->book,
                    name: $file_name,
                    disk: self::DISK,
                    collection: $converter->parser->format->value,
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
