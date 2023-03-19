<?php

namespace App\Engines\Book\Parser\Modules\Interface;

use App\Engines\Book\Parser\Modules\Extractor\Extractor;
use App\Engines\Book\ParserEngine;

interface ParserModuleInterface
{
    public static function make(ParserEngine $parser, bool $debug = false): ParserModule;

    public function parse(array $metadata): Extractor;
}
