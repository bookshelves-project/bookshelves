<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Str;

class PublisherConverter
{
    /**
     * Generate Publisher for Book from ParserEngine.
     */
    public static function create(ParserEngine $parser, Book $book): Publisher|false
    {
        $publisher = false;
        if ($parser->publisher && ! $book->publisher) {
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
            $book->save();
        }
        $book->refresh();

        return $publisher;
    }
}
