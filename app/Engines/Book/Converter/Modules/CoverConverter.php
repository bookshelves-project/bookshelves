<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Services\DirectoryParserService;
use Kiwilan\Steward\Services\MediaService;
use Kiwilan\Steward\Utils\Console;
use ReflectionClass;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     */
    public static function make(Ebook $ebook, Book $book): Book
    {
        // if (! $converter_engine->default
        //     && ! $converter_engine->book->cover_book
        //     && ! empty($converter_engine->parser_engine->cover_file)
        // ) {
        //     try {

        //     } catch (\Throwable $th) {
        //         $console = Console::make();
        //         $console->print(__METHOD__, 'red', $th);
        //         $console->newLine();
        //     }
        //     $converter_engine->book->save();
        // }

        MediaService::make($book, $book->slug, MediaDiskEnum::cover)
            ->setMedia($ebook->cover(false))
            ->setColor()
        ;

        return $book;
    }

    /**
     * Generate Serie image from `public/storage/data/[model_name]s` if JPG file with `Author`|`Serie` `slug` exist.
     */
    public static function getLocal(Author|Serie $model): ?string
    {
        $class = new ReflectionClass($model::class);
        $class = $class->getShortName();
        $model_name = strtolower($class);
        $path = storage_path("app/public/data/{$model_name}s");
        $cover = null;

        $service = DirectoryParserService::make($path);
        $files = $service->files();

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_FILENAME) === $model->slug) {
                $cover = base64_encode(file_get_contents($file));
            }
        }

        return $cover;
    }

    /**
     * Set local cover if exist.
     */
    public static function setLocalCover(Author|Serie $model): Serie|Author
    {
        $disk = MediaDiskEnum::cover;
        $local_cover = self::getLocal($model);

        if ($model instanceof Serie) {
            SerieConverter::setBookCover($model);
        }

        if ($local_cover) {
            $model->clearMediaCollection($disk->value);
            MediaService::make($model, $model->slug, $disk)
                ->setMedia($local_cover)
                ->setColor()
            ;

            $model->save();
        }

        return $model;
    }
}
