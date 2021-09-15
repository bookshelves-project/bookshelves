<?php

namespace App\Providers\BookshelvesConverter;

use App\Models\Book;
use App\Models\Identifier;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Providers\EbookParserEngine\Models\OpfIdentifier;

class IdentifierConverter
{
    public static function create(EbookParserEngine $EPE, Book $book): ?Identifier
    {
        $identifiers = [];
        /** @var OpfIdentifier $value */
        foreach ($EPE->identifiers as $key => $value) {
            if ($value->name === 'isbn') {
                $identifiers['isbn'] = $value->value;
            }
            if ($value->name === 'isbn13') {
                $identifiers['isbn13'] = $value->value;
            }
            if ($value->name === 'doi') {
                $identifiers['doi'] = $value->value;
            }
            if ($value->name === 'amazon') {
                $identifiers['amazon'] = $value->value;
            }
            if ($value->name === 'google') {
                $identifiers['google'] = $value->value;
            }
        }
        $identifier = Identifier::firstOrCreate($identifiers);
        $book->identifier()->associate($identifier);
        $book->save();

        return $identifier;
    }
}
