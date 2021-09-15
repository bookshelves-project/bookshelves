<?php

namespace App\Providers\BookshelvesConverter;

use File;
use App\Models\Book;
use App\Providers\EbookParserEngine\EbookParserEngine;

class BookConverter
{
    /**
     * Generate Book from EbookParserEngine.
     */
    public static function book(EbookParserEngine $EPE): Book
    {
        return Book::firstOrCreate([
            'title'       => $EPE->title,
            'slug'        => $EPE->slug_lang,
            'title_sort'  => $EPE->title_sort,
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

        $serieName = '';
        if ($book->serie) {
            $serieName = $book->serie->slug;
        }
        $authorName = '';
        if ($book->authors) {
            if (array_key_exists(0, $book->authors->toArray())) {
                $authorName = $book->authors[0]->slug . '_';
            }
        }
        $serieNumber = '';
        if ($book->volume) {
            $serieNumber = $book->volume;
            if (1 === strlen((string) $book->volume)) {
                $serieNumber = '0' . $book->volume;
            }
            $serieName = $serieName . '-' . $serieNumber . '_';
        } else {
            $serieName = $serieName . '_';
        }
        $bookName = $book->slug;

        $new_file_name = "$authorName$serieName$bookName";

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
                dump($th);
            }
        }

        return $result;
    }
}
