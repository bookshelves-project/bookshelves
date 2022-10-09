<?php

namespace App\Engines\ParserEngine\Modules\Interface;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\ArchiveParser;

interface XmlInterface
{
    public static function parse(ArchiveParser $parser_engine): ParserEngine;
}
