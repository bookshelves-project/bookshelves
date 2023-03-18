<?php

namespace App\Engines\Parser\Modules\Interface;

use App\Engines\ParserEngine;

interface ModuleInterface
{
    public static function make(ParserEngine $parser): ParserEngine|false;
}
