<?php

namespace App\Services\ConverterEngine;

use App\Models\Book;
use App\Services\ParserEngine\Models\OpfIdentifier;
use App\Services\ParserEngine\ParserEngine;

class BookIdentifierConverter
{
    public static function create(ParserEngine $parser, Book $book): ?Book
    {
        $identifier = null;
        $identifiers = [];
        $fillables = [];

        /** @var OpfIdentifier $value */
        foreach ($parser->identifiers as $key => $value) {
            $fillables = (new Book())->getFillable();
            $fillables = array_filter($fillables, fn ($value) => str_contains($value, 'identifier'));
            $fillables = array_map(fn ($value) => str_replace('identifier_', '', $value), $fillables);
            if (in_array($value->name, $fillables)) {
                $identifiers[$value->name] = $value->value;
            }
        }
        if (! empty($identifiers)) {
            foreach ($fillables as $key => $value) {
                if (array_key_exists($value, $identifiers)) {
                    $book->{"identifier_{$value}"} = $identifiers[$value];
                }
            }
            $book->save();
        }
        $book->save();

        return $book;
    }
}
