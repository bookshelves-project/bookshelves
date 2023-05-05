<?php

namespace App\Engines\Book\Converter\Modules;

use Illuminate\Support\Collection;
use Kiwilan\Ebook\BookEntity;

class IdentifiersConverter
{
    /**
     * Set Identifiers from BookEntity.
     *
     *
     * @return Collection<string, string>
     */
    public static function toCollection(BookEntity $entity): Collection
    {
        $identifiers = collect([]);

        if (! $entity->identifiers()) {
            return $identifiers;
        }

        foreach ($entity->identifiers() as $bookIdentifier) {
            $identifiers[$bookIdentifier->type()] = $bookIdentifier->content();
        }

        return $identifiers;
    }
}
