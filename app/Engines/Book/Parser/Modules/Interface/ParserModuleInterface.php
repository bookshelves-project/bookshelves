<?php

namespace App\Engines\Book\Parser\Modules\Interface;

use App\Engines\Book\ParserEngine;

interface ParserModuleInterface
{
    public static function make(ParserEngine $parser, bool $debug = false): ParserModule;

    /**
     * @param  array<string, mixed>  $metadata
     */
    public function parse(array $metadata): ParserModule;
}
