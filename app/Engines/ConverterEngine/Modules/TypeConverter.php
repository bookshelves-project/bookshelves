<?php

namespace App\Engines\ConverterEngine\Modules;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\Interface\ConverterInterface;
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
    public static function make(ConverterEngine $converter_engine): bool
    {
        $extension = pathinfo($converter_engine->parser_engine->file_path, PATHINFO_EXTENSION);

        $author = $converter_engine->book->meta_author;
        $serie = $converter_engine->book->slug_sort;
        $language = $converter_engine->book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;

        if (pathinfo($converter_engine->parser_engine->file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($converter_engine->parser_engine->file_path);
                MediaService::make(
                    model: $converter_engine->book,
                    name: $file_name,
                    disk: self::DISK,
                    collection: $converter_engine->parser_engine->format->value,
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
