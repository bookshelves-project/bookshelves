<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Modules\Interface\Module;
use App\Engines\ParserEngine\Modules\Interface\ModuleInterface;
use App\Engines\ParserEngine\Parsers\NameParser;

class NameModule extends Module implements ModuleInterface
{
    public static function make(ParserEngine $engine): ParserEngine|false
    {
        return NameParser::make($engine);
    }
}
