<?php

namespace App\Providers\Bookshelves;

use File;
use App\Models\Book;

class EpubGenerator
{
    public static function run(Book $book, string $file_path): bool
    {
        $serie = $book->serie;
        $author = $book->authors[0];

        $ebook_extension = pathinfo($file_path)['extension'];
        if ($serie) {
            $new_file_name_serie = $serie->slug;
        }
        if ($author) {
            $new_file_name_author = $author->slug;
        }
        if ($serie && $author) {
            $serie_number = $book->serie_number;
            if (1 === strlen((string) $serie_number)) {
                $serie_number = '0'.$serie_number;
            }
            $new_file_name = $new_file_name_author.'_'.$new_file_name_serie.'-'.$serie_number.'_'.$book->slug;
        } elseif ($author) {
            $new_file_name = $new_file_name_author.'_'.$book->slug;
        } else {
            $new_file_name = $book->slug;
        }

        $result = false;
        if (pathinfo($file_path)['basename'] !== $new_file_name) {
            try {
                $epub_file = File::get(storage_path("app/public/$file_path"));
                $book->addMediaFromString($epub_file)
                    ->setName($new_file_name)
                    ->setFileName($new_file_name.".$ebook_extension")
                    ->toMediaCollection('books_epubs', 'books_epubs');
                $result = true;
            } catch (\Throwable $th) {
            }
        }

        return $result;
    }
}
