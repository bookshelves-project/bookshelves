<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\NameParser;

class PdfModule
{
    public static function create(ParserEngine $parser): ParserEngine|false
    {
        return NameParser::parse($parser);

        // $im = new Imagick();
        // $im->setResolution(300, 300);     //set the resolution of the resulting jpg
        // $im->readImage('file.pdf[0]');    //[0] for the first page
        // $im->setImageFormat('jpg');
    }
}
