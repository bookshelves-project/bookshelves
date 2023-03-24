<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Modules\Extractor\ComicInfoExtractor;
use App\Engines\Book\Parser\Modules\Extractor\Extractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\ArchiveParser;
use App\Engines\Book\ParserEngine;

class CbaModule extends ParserModule implements ParserModuleInterface
{
    protected function __construct(
        protected ?string $type = null,
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = new self();
        $self->create($parser, $debug);

        $parser = ArchiveParser::make($self)
            ->parse(fn (array $metadata) => $self->parse($metadata))
        ;

        $self->extractor()->setCoverFile($parser->cover());

        return $self;
    }

    public function parse(array $metadata): Extractor
    {
        if (empty($metadata)) {
            return $this->extractor;
        }

        $this->type = $metadata['@root'];

        $extractor = match ($this->type) {
            'ComicInfo' => ComicInfoExtractor::make($metadata),
            default => false,
        };

        if ($this->debug) {
            ParserEngine::printFile($metadata, "{$this->file->name()}-metadata.json");
        }

        if (! $extractor) {
            $this->console->print("CbzModule {$this->type} not supported", 'red');
            $this->console->newLine();
        }

        $this->extractor = $extractor;
        $this->extractor()->setPageCount($metadata['count']);

        return $this->extractor;
    }
}
