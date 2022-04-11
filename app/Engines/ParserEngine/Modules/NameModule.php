<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\NameParser;

class NameModule
{
    public static function create(ParserEngine $engine): ParserEngine|false
    {
        return NameParser::parse($engine);
    }
}
