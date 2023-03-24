<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Modules\Extractor\Extractor;
use App\Engines\Book\Parser\Modules\Extractor\PdfExtractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\PdfParser;
use App\Engines\Book\ParserEngine;

/**
 * Parse PDF to extract cover with `ImageMagick` (if installed) and metadata.
 */
class PdfModule extends ParserModule implements ParserModuleInterface
{
    protected function __construct(
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = new self();
        $self->create($parser, $debug);

        $parser = PdfParser::make($self)
            ->parse(fn (array $metadata) => $self->parse($metadata))
            ->extractCover()
        ;

        $self->extractor()->setCoverFile($parser->cover());

        return $self;
    }

    public function parse(array $metadata): Extractor
    {
        if (empty($metadata)) {
            return $this->extractor;
        }

        $this->extractor = PdfExtractor::make($metadata);

        return $this->extractor;
    }
}
