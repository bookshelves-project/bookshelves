<?php

namespace App\Engines\ParserEngine\Modules\Interface;

use App\Engines\ParserEngine;

interface ModuleInterface
{
    public static function make(ParserEngine $engine): ParserEngine|false;
}
