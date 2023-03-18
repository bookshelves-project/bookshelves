<?php

namespace App\Engines\Converter\Modules;

use App\Engines\Parser\Models\BookEntity;
use Illuminate\Support\Collection;

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
            $identifiers[$bookIdentifier->name()] = $bookIdentifier->value();
        }

        return $identifiers;
    }
}
