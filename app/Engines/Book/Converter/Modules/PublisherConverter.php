<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Publisher;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Ebook;

class PublisherConverter
{
    /**
     * Set Publisher from Ebook.
     */
    public static function toModel(Ebook $ebook): ?Publisher
    {
        if (! $ebook->publisher()) {
            return null;
        }

        $publisherExist = Publisher::whereSlug(Str::slug($ebook->publisher()))->first();

        if (! $publisherExist) {
            $name = $ebook->publisher();

            return Publisher::firstOrCreate([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        return $publisherExist;
    }
}
