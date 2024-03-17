<?php

namespace App\Engines\Book\Converter\Modules;

use Illuminate\Support\Collection;
use Kiwilan\Ebook\Ebook;

class IdentifierModule
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

        if (! $ebook->getIdentifiers()) {
            return $identifiers;
        }

        foreach ($ebook->getIdentifiers() as $bookIdentifier) {
            $identifiers[$bookIdentifier->getScheme()] = $bookIdentifier->getValue();
        }

        return $identifiers;
    }
}
