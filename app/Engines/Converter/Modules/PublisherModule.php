<?php

namespace App\Engines\Converter\Modules;

use App\Models\Publisher;
use Illuminate\Support\Str;

class PublisherModule
{
    public static function make(?string $publisher): ?Publisher
    {
        if (! $publisher) {
            return null;
        }

        return Publisher::create([
            'name' => $publisher,
            'slug' => Str::slug($publisher),
        ]);
    }
}
