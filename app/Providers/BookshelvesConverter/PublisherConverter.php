<?php

namespace App\Providers\BookshelvesConverter;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Str;
use App\Providers\EbookParserEngine\EbookParserEngine;

class PublisherConverter
{
    /**
     * Generate Publisher for Book from EbookParserEngine.
     */
    public static function create(EbookParserEngine $EPE, Book $book): Book
    {
        if ($EPE->publisher) {
            $publisherIfExist = Publisher::whereSlug(Str::slug($EPE->publisher))->first();
            $publisher = null;
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $EPE->publisher,
                    'slug' => Str::slug($EPE->publisher),
                ]);
            } else {
                $publisher = $publisherIfExist;
            }

            $book->publisher()->associate($publisher);
        }

        return $book;
    }
}
