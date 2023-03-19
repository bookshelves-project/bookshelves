<?php

namespace App\Engines\Book\Parser\Modules\Interface;

use App\Engines\Book\Parser\Models\BookEntity;
use App\Engines\Book\Parser\Models\BookEntityFile;
use App\Engines\Book\Parser\Modules\Extractor\Extractor;
use App\Engines\Book\ParserEngine;
use Kiwilan\Steward\Utils\Console;

abstract class ParserModule
{
    protected BookEntityFile $file;

    protected bool $debug;

    protected ?Extractor $extractor = null;

    protected ?Console $console = null;

    protected function __construct(
    ) {
    }

    public function create(ParserEngine $parser, bool $debug = false): self
    {
        $this->console = Console::make();

        $this->file = $parser->file();
        $this->debug = $debug;

        return $this;
    }

    public function toBookEntity(BookEntity $book): BookEntity
    {
        $book->setTitle($this->extractor?->title());
        $book->setDescription($this->extractor?->description());
        $book->setDate($this->extractor?->date());
        $book->setPublisher($this->extractor?->publisher());
        $book->setLanguage($this->extractor?->language());
        $book->setRights($this->extractor?->rights());
        $book->setContributor($this->extractor?->contributor());
        $book->setSerie($this->extractor?->serie());
        $book->setVolume($this->extractor?->volume());
        $book->setPageCount($this->extractor?->pageCount());
        $book->setTags($this->extractor?->tags());
        $book->setAuthors($this->extractor?->authors());
        $book->setIdentifiers($this->extractor?->identifiers());

        $book->setCover($this->extractor?->cover());
        $book->setExtra();

        return $book;
    }

    public function file(): BookEntityFile
    {
        return $this->file;
    }

    public function debug(): bool
    {
        return $this->debug;
    }

    public function extractor(): ?Extractor
    {
        return $this->extractor;
    }
}
