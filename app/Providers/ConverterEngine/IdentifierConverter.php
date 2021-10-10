<?php

namespace App\Providers\ConverterEngine;

use App\Models\Book;
use App\Models\Identifier;
use App\Providers\ParserEngine\Models\OpfIdentifier;
use App\Providers\ParserEngine\ParserEngine;

class IdentifierConverter
{
    public static function create(ParserEngine $parser, Book $book): ?Identifier
    {
        $identifiers = [];
        /** @var OpfIdentifier $value */
        foreach ($parser->identifiers as $key => $value) {
            if ('isbn' === $value->name) {
                $identifiers['isbn'] = $value->value;
            }
            if ('isbn13' === $value->name) {
                $identifiers['isbn13'] = $value->value;
            }
            if ('doi' === $value->name) {
                $identifiers['doi'] = $value->value;
            }
            if ('amazon' === $value->name) {
                $identifiers['amazon'] = $value->value;
            }
            if ('google' === $value->name) {
                $identifiers['google'] = $value->value;
            }
        }
        $identifier = Identifier::firstOrCreate($identifiers);
        $book->identifier()->associate($identifier);
        $book->save();

        return $identifier;
    }
}
