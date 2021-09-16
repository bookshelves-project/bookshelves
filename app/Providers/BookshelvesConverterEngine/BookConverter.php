<?php

namespace App\Providers\BookshelvesConverterEngine;

use Str;
use File;
use App\Models\Book;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Utils\BookshelvesTools;

class BookConverter
{
    /**
     * Generate Book from EbookParserEngine.
     */
    public static function create(EbookParserEngine $EPE): Book
    {
        return Book::firstOrCreate([
            'title'       => $EPE->title,
            'slug'        => $EPE->slug_lang,
            'title_sort'  => $EPE->title_serie_sort,
            'contributor' => implode(' ', $EPE->contributor),
            'description' => $EPE->description,
            'date'        => $EPE->date,
            'rights'      => $EPE->rights,
            'volume'      => $EPE->volume,
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
        $serie = $book->title_sort;
        $language = $book->language_slug;
        $new_file_name = Str::slug($author."_".$serie."_".$language);

        $result = false;
        if (pathinfo($epubFilePath)['basename'] !== $new_file_name) {
            try {
                $epub_file = File::get($epubFilePath);
                $book->addMediaFromString($epub_file)
                    ->setName($new_file_name)
                    ->setFileName($new_file_name . ".$ebook_extension")
                    ->toMediaCollection('epubs', 'epubs');
                $result = true;
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $result;
    }
}
