<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Models\Publisher;
use Illuminate\Support\Str;

class PublisherConverter
{
    /**
     * Generate Publisher for Book from ParserEngine.
     */
    public static function create(ConverterEngine $converter): Publisher|false
    {
        $publisher = false;
        if ($converter->parser->publisher && ! $converter->book->publisher) {
            $publisherIfExist = Publisher::whereSlug(Str::slug($converter->parser->publisher))->first();
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $converter->parser->publisher,
                    'slug' => Str::slug($converter->parser->publisher),
                ]);
            } else {
                $publisher = $publisherIfExist;
            }

            $converter->book->publisher()->associate($publisher);
            $converter->book->save();
        }
        $converter->book->refresh();

        return $publisher;
    }
}
