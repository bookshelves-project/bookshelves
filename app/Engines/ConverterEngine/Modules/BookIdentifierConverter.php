<?php

namespace App\Engines\ConverterEngine\Modules;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\Interface\ConverterInterface;
use App\Models\Book;

class BookIdentifierConverter implements ConverterInterface
{
    public static function make(ConverterEngine $converter_engine): ?Book
    {
        if ($converter_engine->parser_engine->identifiers && ! $converter_engine->book->identifiers) {
            $identifiers = [];

            foreach ($converter_engine->parser_engine->identifiers as $book_identifier) {
                $identifiers[$book_identifier->name] = $book_identifier->value;
            }

            $converter_engine->book->isbn10 = $identifiers['isbn10'] ?? null;
            $converter_engine->book->isbn13 = $identifiers['isbn13'] ?? null;

            $converter_engine->book->identifiers = $identifiers;
            $converter_engine->book->save();
        }

        return $converter_engine->book;
    }
}
