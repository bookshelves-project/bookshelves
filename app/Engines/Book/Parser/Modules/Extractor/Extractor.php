<?php

namespace App\Engines\Book\Parser\Modules\Extractor;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Models\BookEntityCover;
use App\Engines\Book\Parser\Models\BookEntityIdentifier;

abstract class Extractor
{
    /** @var array<string, mixed> */
    protected array $metadata = [];

    /** @var BookEntityAuthor[] */
    protected ?array $authors = [];

    /** @var string[] */
    protected ?array $tags = [];

    /** @var BookEntityIdentifier[] */
    protected ?array $identifiers = [];

    protected function __construct(
        protected ?string $title = null,
        protected ?string $description = null,
        protected ?string $date = null,
        protected ?string $publisher = null,
        protected ?string $language = null,
        protected ?string $rights = null,
        protected ?string $contributor = null,
        protected ?string $serie = null,
        protected ?int $volume = null,
        protected ?int $pageCount = null,
        protected ?BookEntityCover $cover = null,
    ) {
        $this->cover = new BookEntityCover();
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

    public function volume(): ?int
    {
        return $this->volume;
    }

    public function pageCount(): ?int
    {
        return $this->pageCount;
    }

    /**
     * @return array<BookEntityAuthor>
     */
    public function authors(): ?array
    {
        return $this->authors;
    }

    /**
     * @return array<string>
     */
    public function tags(): ?array
    {
        return $this->tags;
    }

    /**
     * @return array<BookEntityIdentifier>
     */
    public function identifiers(): ?array
    {
        return $this->identifiers;
    }

    public function cover(): ?BookEntityCover
    {
        return $this->cover;
    }

    public function setPageCount(?int $pageCount): self
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function setCoverFile(?string $coverFile): self
    {
        $this->cover->setFile($coverFile);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'publisher' => $this->publisher,
            'language' => $this->language,
            'rights' => $this->rights,
            'contributor' => $this->contributor,
            'serie' => $this->serie,
            'volume' => $this->volume,
            'pageCount' => $this->pageCount,
            'authors' => $this->authors,
            'tags' => $this->tags,
            'identifiers' => $this->identifiers,
            'cover' => $this->cover,
        ];
    }

    public function __toString(): string
    {
        return "{$this->title}";
    }
}
