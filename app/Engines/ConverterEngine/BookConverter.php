<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\BookTypeEnum;
use App\Models\Book;
use App\Services\ConsoleService;
use File;
use Str;

class BookConverter
{
    /**
     * Generate Book from ParserEngine.
     */
    public static function create(ParserEngine $parser): Book
    {
        return Book::firstOrCreate([
            'title' => $parser->title,
            'slug' => $parser->title_slug_lang,
            'slug_sort' => $parser->title_serie_sort,
            'contributor' => implode(' ', $parser->contributor),
            'description' => $parser->description,
            'released_on' => $parser->released_on ?? null,
            'rights' => $parser->rights,
            'volume' => $parser->volume,
            'type' => BookTypeEnum::novel(),
        ]);
    }

    /**
     * Generate new EPUB file with standard name.
     * Managed by spatie/laravel-medialibrary.
     */
    public static function epub(Book $book, string $epubFilePath): bool
    {
        $ebook_extension = pathinfo($epubFilePath)['extension'];

        $author = $book->meta_author;
        $serie = $book->slug_sort;
        $language = $book->language_slug;
        $new_file_name = Str::slug($author.'_'.$serie.'_'.$language);

        $result = false;
        if (pathinfo($epubFilePath)['basename'] !== $new_file_name) {
            try {
                $epub_file = File::get($epubFilePath);
                $book->addMediaFromString($epub_file)
                    ->setName($new_file_name)
                    ->setFileName($new_file_name.".{$ebook_extension}")
                    ->toMediaCollection('epubs', 'epubs')
                ;
                $result = true;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, $th, true);
            }
        }

        return $result;
    }
}
