<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;

interface XmlInterface
{
    public static function parse(ArchiveParser $parser): ParserEngine;
}
