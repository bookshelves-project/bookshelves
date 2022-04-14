<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;

interface ModuleInterface
{
    public static function create(ParserEngine $engine): ParserEngine|false;
}
