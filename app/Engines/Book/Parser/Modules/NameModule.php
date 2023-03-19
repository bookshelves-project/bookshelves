<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Modules\Extractor\NameExtractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\NameParser;
use App\Engines\Book\ParserEngine;

class NameModule extends ParserModule implements ParserModuleInterface
{
    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = new self();
        $self->create($parser, $debug);

        NameParser::make($self)
            ->parse(fn (array $metadata) => NameExtractor::make($metadata))
        ;

        return $self;
    }

    public function parse(array $metadata): NameExtractor
    {
        return NameExtractor::make($metadata);
    }
}
