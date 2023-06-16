<?php

namespace App\Engines\Book\Converter\Modules;

use Illuminate\Support\Collection;
use Kiwilan\Ebook\Ebook;

class IdentifiersConverter
{
    /**
     * Set Identifiers from Ebook.
     *
     *
     * @return Collection<string, string>
     */
    public static function toCollection(Ebook $ebook): Collection
    {
        $identifiers = collect([]);

        if (! $ebook->identifiers()) {
            return $identifiers;
        }

        foreach ($ebook->identifiers() as $bookIdentifier) {
            $identifiers[$bookIdentifier->scheme()] = $bookIdentifier->value();
        }

        return $identifiers;
    }
}
