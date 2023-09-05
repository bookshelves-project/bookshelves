<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Publisher;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Ebook;

class PublisherConverter
{
    public static function make(?string $publisher): ?Publisher
    {
        if (! $publisher) {
            return null;
        }

        return new Publisher([
            'name' => $publisher,
            'slug' => Str::slug($publisher),
        ]);
    }

    /**
     * Set Publisher from Ebook.
     */
    public static function toModel(Ebook $ebook): ?Publisher
    {
        if (! $ebook->getPublisher()) {
            return null;
        }

        $publisherExist = Publisher::whereSlug(Str::slug($ebook->getPublisher()))->first();

        if (! $publisherExist) {
            $name = $ebook->getPublisher();

            return Publisher::firstOrCreate([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        return $publisherExist;
    }
}
