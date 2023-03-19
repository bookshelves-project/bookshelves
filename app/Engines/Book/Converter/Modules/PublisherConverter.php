<?php

namespace App\Engines\Book\Converter\Modules;

use App\Engines\Book\Parser\Models\BookEntity;
use App\Models\Publisher;
use Illuminate\Support\Str;

class PublisherConverter
{
    /**
     * Set Publisher from BookEntity.
     */
    public static function toModel(BookEntity $entity): ?Publisher
    {
        if (! $entity->publisher()) {
            return null;
        }

        $publisherExist = Publisher::whereSlug(Str::slug($entity->publisher()))->first();

        if (! $publisherExist) {
            $name = $entity->publisher();

            return Publisher::firstOrCreate([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        return $publisherExist;
    }
}
