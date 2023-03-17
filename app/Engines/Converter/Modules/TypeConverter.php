<?php

namespace App\Engines\Converter\Modules;

use App\Engines\Converter\Modules\Interface\ConverterInterface;
use App\Engines\ConverterEngine;
use App\Enums\MediaDiskEnum;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Kiwilan\Steward\Enums\SpatieMediaMethodEnum;
use Kiwilan\Steward\Services\MediaService;
use Kiwilan\Steward\Utils\Console;

class TypeConverter implements ConverterInterface
{
    public const DISK = MediaDiskEnum::format;

    /**
     * Generate new file with standard name.
     * Managed by spatie/laravel-medialibrary.
     */
    public static function make(ConverterEngine $converter): bool
    {
        $extension = pathinfo($converter->parser_engine->file_path, PATHINFO_EXTENSION);

        $author = $converter->book->meta_author;
        $serie = $converter->book->slug_sort;
        $language = $converter->book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;

        if (pathinfo($converter->parser_engine->file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($converter->parser_engine->file_path);
                MediaService::make(
                    model: $converter->book,
                    name: $file_name,
                    disk: self::DISK,
                    collection: $converter->parser_engine->format->value,
                    extension: $extension,
                    method: SpatieMediaMethodEnum::addMediaFromString
                )->setMedia($file);
                $result = true;
            } catch (\Throwable $th) {
                $console = Console::make();
                $console->print(__METHOD__, 'red', $th);
                $console->newLine();
            }
        }

        return $result;
    }
}
