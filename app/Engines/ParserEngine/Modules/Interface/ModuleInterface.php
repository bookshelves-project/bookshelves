<?php

namespace App\Engines\ParserEngine\Modules\Interface;

use App\Engines\ParserEngine;

interface ModuleInterface
{
    public static function create(ParserEngine $engine): ParserEngine|false;
}
