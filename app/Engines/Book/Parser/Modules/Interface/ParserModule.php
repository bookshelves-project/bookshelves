<?php

namespace App\Engines\Book\Parser\Modules\Interface;

use App\Engines\Book\ParserEngine;
use App\Engines\Book\Parser\Models\BookEntity;
use App\Engines\Book\Parser\Models\BookEntityCover;
use App\Engines\Book\Parser\Models\BookEntityFile;
use Kiwilan\Steward\Utils\Console;

abstract class ParserModule
{
    /** @var array<string, mixed> */
    protected array $metadata = [];

    /** @var string[] */
    protected array $tags = [];

    /** @var BookEntityAuthor[] */
    protected array $authors = [];

    /** @var BookEntityIdentifier[] */
    protected array $identifiers = [];

    protected BookEntityFile $file;

    protected bool $debug;

    protected ?BookEntityCover $cover = null;

    protected ?string $title = null;

    protected ?string $description = null;

    protected ?string $date = null;

    protected ?string $publisher = null;

    protected ?string $language = null;

    protected ?string $rights = null;

    protected ?string $contributor = null;

    protected ?string $serie = null;

    protected ?string $volume = null;

    protected ?int $pageCount = null;

    protected ?Console $console = null;

    protected function __construct(
    ) {
        $this->console = Console::make();
        $this->cover = new BookEntityCover();
    }

    public static function create(ParserEngine $parser, string $className, bool $debug = false): ParserModule&ParserModuleInterface
    {
        /** @var ParserModule&ParserModuleInterface */
        $module = new $className();

        $module->file = $parser->file();
        $module->debug = $debug;

        return $module;
    }

    public function toBookEntity(BookEntity $book): BookEntity
    {
        $book->setTitle($this->title);
        $book->setDescription($this->description);
        $book->setDate($this->date);
        $book->setPublisher($this->publisher);
        $book->setLanguage($this->language);
        $book->setRights($this->rights);
        $book->setContributor($this->contributor);
        $book->setSerie($this->serie);
        $book->setVolume($this->volume);
        $book->setPageCount($this->pageCount);
        $book->setTags($this->tags);
        $book->setAuthors($this->authors);
        $book->setIdentifiers($this->identifiers);

        $book->makeCover($this->cover);
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

    public function cover(): ?BookEntityCover
    {
        return $this->cover;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function date(): ?string
    {
        return $this->date;
    }

    public function publisher(): ?string
    {
        return $this->publisher;
    }

    public function language(): ?string
    {
        return $this->language;
    }

    public function rights(): ?string
    {
        return $this->rights;
    }

    public function contributor(): ?string
    {
        return $this->contributor;
    }

    public function serie(): ?string
    {
        return $this->serie;
    }

    public function volume(): ?string
    {
        return $this->volume;
    }

    public function pageCount(): ?int
    {
        return $this->pageCount;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    /**
     * @return string[]
     */
    public function tags(): array
    {
        return $this->tags;
    }

    /**
     * @return BookEntityAuthor[]
     */
    public function authors(): array
    {
        return $this->authors;
    }

    /**
     * @return BookEntityIdentifier[]
     */
    public function identifiers(): array
    {
        return $this->identifiers;
    }

    public function setCover(): static
    {
        $this->cover = new BookEntityCover();

        return $this;
    }

    public function setCoverName(string $name): static
    {
        $this->cover->setName($name);

        return $this;
    }

    public function setCoverExtension(string $extension): static
    {
        $this->cover->setExtension($extension);

        return $this;
    }

    public function setCoverFile(string $file): static
    {
        $this->cover->setFile($file);

        return $this;
    }

    public function setPageCount(int $pageCount): static
    {
        $this->pageCount = $pageCount;

        return $this;
    }
}
