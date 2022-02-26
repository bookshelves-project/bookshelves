<?php

namespace App\Engines\ConverterEngine;

use App\Models\Book;
use App\Services\ConsoleService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TypeConverter
{
    /**
     * Generate new EPUB file with standard name.
     * Managed by spatie/laravel-medialibrary.
     */
    public static function cbz(Book $book, string $file_path): bool
    {
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $author = $book->meta_author;
        $serie = $book->slug_sort;
        $language = $book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;
        if (pathinfo($file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($file_path);
                $book->addMediaFromString($file)
                    ->setName($file_name)
                    ->setFileName($file_name.".{$extension}")
                    ->toMediaCollection('cbz', 'formats')
                ;
                $result = true;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, $th, true);
            }
        }

        return $result;
    }

    public static function epub(Book $book, string $file_path): bool
    {
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $author = $book->meta_author;
        $serie = $book->slug_sort;
        $language = $book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;
        if (pathinfo($file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($file_path);
                $book->addMediaFromString($file)
                    ->setName($file_name)
                    ->setFileName($file_name.".{$extension}")
                    ->toMediaCollection('epub', 'formats')
                ;
                $result = true;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, $th, true);
            }
        }

        return $result;
    }

    public static function pdf(Book $book, string $file_path): bool
    {
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $author = $book->meta_author;
        $serie = $book->slug_sort;
        $language = $book->language_slug;
        $file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;
        if (pathinfo($file_path, PATHINFO_BASENAME) !== $file_name) {
            try {
                $file = File::get($file_path);
                $book->addMediaFromString($file)
                    ->setName($file_name)
                    ->setFileName($file_name.".{$extension}")
                    ->toMediaCollection('pdf', 'formats')
                ;
                $result = true;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, $th, true);
            }
        }

        return $result;
    }
}
