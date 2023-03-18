<?php

namespace App\Engines;

use App\Engines\Book\ConverterEngine;
use App\Engines\Book\Parser\Parsers\BookFile;
use App\Engines\Book\ParserEngine;

class BookEngine
{
    public static function make(BookFile $file, bool $debug = false, bool $default = false): void
    {
        $entity = ParserEngine::make($file, $debug);
        ConverterEngine::make($entity, $default);
    }
}
