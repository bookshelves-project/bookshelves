<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\XmlParser;

class CbrModule
{
    public static function create(ParserEngine $engine): ParserEngine|false
    {
        return CbzModule::create($engine, true);
    }
}
