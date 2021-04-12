<?php

namespace App\Providers\Bookshelves;

use File;
use App\Models\Book;

class EpubGenerator
{
    /**
     * Generate new EPUB file with standard name.
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Book   $book
     * @param string $file_path
     *
     * @return bool
     */
    public static function run(Book $book, string $file_path): bool
    {
        $ebook_extension = pathinfo($file_path)['extension'];

        $serieName = '';
        if ($book->serie) {
            $serieName = $book->serie->slug;
        }
        $authorName = '';
        if ($book->authors) {
            if (array_key_exists(0, $book->authors->toArray())) {
                $authorName = $book->authors[0]->slug.'_';
            }
        }
        $serieNumber = '';
        if ($book->volume) {
            $serieNumber = $book->volume;
            if (1 === strlen((string) $book->volume)) {
                $serieNumber = '0'.$book->volume;
            }
            $serieName = $serieName.'-'.$serieNumber.'_';
        } else {
            $serieName = $serieName.'_';
        }
        $bookName = $book->slug;

        $new_file_name = "$authorName$serieName$bookName";

        $result = false;
        if (pathinfo($file_path)['basename'] !== $new_file_name) {
            try {
                $epub_file = File::get(storage_path("app/public/$file_path"));
                $book->addMediaFromString($epub_file)
                    ->setName($new_file_name)
                    ->setFileName($new_file_name.".$ebook_extension")
                    ->toMediaCollection('epubs', 'epubs');
                $result = true;
            } catch (\Throwable $th) {
            }
        }

        return $result;
    }
}
