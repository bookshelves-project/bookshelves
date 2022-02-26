<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;

class CbzModule
{
    public static function create(ParserEngine $parser): ParserEngine|false
    {
        dump($parser);

        return false;
    }
}
