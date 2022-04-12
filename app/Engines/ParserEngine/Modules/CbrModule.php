<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\ArchiveInterface;
use App\Engines\ParserEngine\Parsers\ArchiveParser;

class CbrModule implements ArchiveInterface
{
    public static function create(ParserEngine $engine): ParserEngine|false
    {
        $archive = new ArchiveParser($engine, CbrModule::class);
        $archive->find_cover = true;
        $archive->is_rar = true;

        return $archive->open();
    }

    public static function parse(ArchiveParser $parser): ParserEngine
    {
        return CbzModule::parse($parser);
    }
}
