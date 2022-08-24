<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Engines\ParserEngine\Models\BookIdentifier;
use App\Models\Book;

class BookIdentifierConverter
{
    public static function create(ConverterEngine $converter): ?Book
    {
        if ($converter->parser->identifiers && ! $converter->book->identifiers) {
            $identifiers = [];
            $fillables = [];

            /** @var BookIdentifier $value */
            foreach ($converter->parser->identifiers as $key => $value) {
                $fillables = (new Book())->getFillable();
                $fillables = array_filter($fillables, fn ($value) => str_contains($value, 'isbn'));
                if (in_array($value->name, $fillables)) {
                    $identifier = trim(str_replace('-', '', $value->value));
                    $identifiers[$value->name] = $identifier;
                }
            }
            if (! empty($identifiers)) {
                foreach ($fillables as $key => $value) {
                    if (array_key_exists($value, $identifiers)) {
                        $converter->book->{$value} = $identifiers[$value];
                    }
                }
                $converter->book->identifiers = $converter->parser->identifiers;
            }
            $converter->book->save();
        }

        return $converter->book;
    }
}
