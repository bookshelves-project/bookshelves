<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Modules\Extractor\EpubTwoAndThreeExtractor;
use App\Engines\Book\Parser\Modules\Extractor\Extractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\ArchiveParser;
use App\Engines\Book\ParserEngine;

class EpubModule extends ParserModule implements ParserModuleInterface
{
    protected function __construct(
        protected float $version = 2.0,
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = new self();
        $self->create($parser, $debug);

        $parser = ArchiveParser::make($self)
            ->setIndexExtension('opf')
            ->parse(fn (array $metadata) => $self->parse($metadata))
        ;

        $self->extractor()->setCoverFile($parser->cover());

        return $self;
    }

    public function parse(array $metadata): Extractor
    {
        if ($metadata['@attributes'] && $version = $metadata['@attributes']['version']) {
            $this->version = floatval($version);
        }

        $extractor = match ($this->version) {
            2.0 => EpubTwoAndThreeExtractor::make($metadata),
            3.0 => EpubTwoAndThreeExtractor::make($metadata),
            default => false,
        };

        if ($this->debug) {
            ParserEngine::printFile($metadata, "{$this->file->name()}-metadata.json");
        }

        if (! $extractor) {
            $this->console->print("EpubModule {$this->version} not supported", 'red');
            $this->console->newLine();
        }

        $this->extractor = $extractor;

        return $this->extractor;
    }
}
