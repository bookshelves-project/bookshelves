<?php

namespace App\Engines\Parser\Modules\Interface;

use App\Engines\ParserEngine;

interface ParserModuleInterface
{
    public static function make(ParserEngine $parser, bool $debug = false): ParserModule;

    /**
     * @param  array<string, mixed>  $metadata
     */
    public function parse(array $metadata): ParserModule;
}
