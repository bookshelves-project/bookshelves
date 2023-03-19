<?php

namespace App\Engines;

use App\Engines\Book\ConverterEngine;
use App\Engines\Book\Parser\Utils\BookFileReader;
use App\Engines\Book\ParserEngine;

class BookEngine
{
    public static function make(BookFileReader $file, bool $debug = false, bool $default = false): void
    {
        $entity = ParserEngine::make($file, $debug);
        ConverterEngine::make($entity, $default);
    }
}
