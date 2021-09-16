<?php

namespace App\Providers\BookshelvesConverterEngine;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Str;
use App\Providers\EbookParserEngine\EbookParserEngine;

class PublisherConverter
{
    /**
     * Generate Publisher for Book from EbookParserEngine.
     */
    public static function create(EbookParserEngine $epe, Book $book): Publisher|false
    {
        $publisher = false;
        if ($epe->publisher) {
            $publisherIfExist = Publisher::whereSlug(Str::slug($epe->publisher))->first();
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $epe->publisher,
                    'slug' => Str::slug($epe->publisher),
                ]);
            } else {
                $publisher = $publisherIfExist;
            }

            $book->publisher()->associate($publisher);
        }
        $book->refresh();

        return $publisher;
    }
}
