<?php

namespace App\Providers\ConverterEngine;

use App\Models\Book;
use App\Models\Identifier;
use App\Providers\ParserEngine\ParserEngine;
use App\Providers\ParserEngine\Models\OpfIdentifier;

class IdentifierConverter
{
    public static function create(ParserEngine $parser, Book $book): ?Identifier
    {
        $identifiers = [];
        /** @var OpfIdentifier $value */
        foreach ($parser->identifiers as $key => $value) {
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
