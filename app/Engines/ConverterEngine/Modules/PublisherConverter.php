<?php

namespace App\Engines\ConverterEngine\Modules;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\Interface\ConverterInterface;
use App\Models\Publisher;
use Illuminate\Support\Str;

class PublisherConverter implements ConverterInterface
{
    /**
     * Generate Publisher for Book from ParserEngine.
     */
    public static function make(ConverterEngine $converter_engine): Publisher|false
    {
        $publisher = false;

        if ($converter_engine->parser_engine->publisher && ! $converter_engine->book->publisher) {
            $publisher_exist = Publisher::whereSlug(Str::slug($converter_engine->parser_engine->publisher))->first();

            if (! $publisher_exist) {
                $name = $converter_engine->parser_engine->publisher;
                $publisher = Publisher::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name),
                ]);
            } else {
                $publisher = $publisher_exist;
            }

            $converter_engine->book->publisher()->associate($publisher);
            $converter_engine->book->save();
        }
        $converter_engine->book->refresh();

        return $publisher;
    }
}
