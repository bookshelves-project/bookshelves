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

            foreach ($converter->parser->identifiers as $book_identifier) {
                $identifiers[$book_identifier->name] = $book_identifier->value;
            }

            $converter->book->isbn10 = $identifiers['isbn10'] ?? null;
            $converter->book->isbn13 = $identifiers['isbn13'] ?? null;

            $converter->book->identifiers = $identifiers;
            $converter->book->save();
        }

        return $converter->book;
    }
}
