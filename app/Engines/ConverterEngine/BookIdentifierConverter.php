<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\BookIdentifier;
use App\Models\Book;

class BookIdentifierConverter
{
    public static function create(ParserEngine $parser, Book $book): ?Book
    {
        $identifier = null;
        $identifiers = [];
        $fillables = [];

        /** @var BookIdentifier $value */
        foreach ($parser->identifiers as $key => $value) {
            $fillables = (new Book())->getFillable();
            $fillables = array_filter($fillables, fn ($value) => str_contains($value, 'isbn'));
            if (in_array($value->name, $fillables)) {
                $identifiers[$value->name] = $value->value;
            }
        }
        if (! empty($identifiers)) {
            foreach ($fillables as $key => $value) {
                if (array_key_exists($value, $identifiers)) {
                    $book->{$value} = $identifiers[$value];
                }
            }
            $book->identifiers = $parser->identifiers;
        }
        $book->save();

        return $book;
    }
}
