<?php

namespace App\Engines\Parser\Modules\Interface;

use App\Engines\Parser\Parsers\ArchiveParser;
use App\Engines\ParserEngine;

interface XmlInterface
{
    public static function parse(ArchiveParser $parser): ParserEngine;
}
