<?php

namespace App\Providers\ConverterEngine;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Str;
use App\Providers\ParserEngine\ParserEngine;

class PublisherConverter
{
    /**
     * Generate Publisher for Book from ParserEngine.
     */
    public static function create(ParserEngine $parser, Book $book): Publisher|false
    {
        $publisher = false;
        if ($parser->publisher) {
            $publisherIfExist = Publisher::whereSlug(Str::slug($parser->publisher))->first();
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $parser->publisher,
                    'slug' => Str::slug($parser->publisher),
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
