<?php

namespace App\Engines\Parser\Modules;

use App\Engines\Parser\Modules\Interface\Module;
use App\Engines\Parser\Modules\Interface\ModuleInterface;
use App\Engines\Parser\Parsers\NameParser;
use App\Engines\ParserEngine;

class NameModule extends Module implements ModuleInterface
{
    public static function make(ParserEngine $engine): ParserEngine|false
    {
        return NameParser::make($engine);
    }
}
