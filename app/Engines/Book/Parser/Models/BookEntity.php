<?php

namespace App\Engines\Book\Parser\Models;

use App\Engines\Book\Parser\Utils\BookFileReader;
use App\Enums\BookFormatEnum;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\Console;

class BookEntity
{
    /** @var BookEntityAuthor[] */
    protected ?array $authors = [];

    /** @var BookEntityIdentifier[] */
    protected ?array $identifiers = [];

    /** @var string[] */
    protected ?array $tags = [];

    protected function __construct(
        protected ?BookEntityFile $file = null,
        protected ?string $title = null,
        protected ?string $description = null,
        protected ?DateTime $releasedOn = null,
        protected ?string $date = null,
        protected ?string $publisher = null,
        protected ?string $language = null,
        protected ?string $rights = null,
        protected ?string $contributor = null,
        protected ?string $serie = null,
        protected ?int $volume = null,
        protected ?int $pageCount = null,
        protected ?BookEntityCover $cover = null,
        protected ?BookEntityExtra $extra = null,
    ) {
    }

    public static function make(BookFileReader $file): ?self
    {
        $self = new self();
        $self->setFile($file);
        $formats = BookFormatEnum::toNames();

        if (! array_key_exists($self->file->extensionFormat(), $formats)) {
            $console = Console::make();
            $console->print("{$file->path()} ParserEngine error: extension is not recognized");

            return null;
        }

        return $self;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function serie(): ?string
    {
        return $this->serie;
    }

    public function volume(): ?int
    {
        return $this->volume;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function language(): ?string
    {
        return $this->language;
    }

    public function rights(): ?string
    {
        return $this->rights;
    }

    public function date(): ?string
    {
        return $this->date;
    }

    public function releasedOn(): ?DateTime
    {
        return $this->releasedOn;
    }

    public function file(): ?BookEntityFile
    {
        return $this->file;
    }

    public function cover(): ?BookEntityCover
    {
        return $this->cover;
    }

    public function extra(): ?BookEntityExtra
    {
        return $this->extra;
    }

    /**
     * Get the value of authors.
     *
     * @return BookEntityAuthor[]
     */
    public function authors(): ?array
    {
        return $this->authors;
    }

    /**
     * Get the value of contributor.
     */
    public function contributor(): ?string
    {
        return $this->contributor;
    }

    public function publisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * Get the value of identifiers.
     *
     * @return BookEntityIdentifier[]
     */
    public function identifiers(): ?array
    {
        return $this->identifiers;
    }

    /**
     * Get the value of tags.
     *
     * @return string[]
     */
    public function tags(): ?array
    {
        return $this->tags;
    }

    public function pageCount(): ?int
    {
        return $this->pageCount;
    }

    public function setTitle(?string $title): self
    {
        if (! $title) {
            $title = $this->file->name();
        }

        $title = Str::limit($title, 250);
        $title = Str::replace('`', '’', $title);

        $this->title = $title;

        return $this;
    }

    public function setSerie(?string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $description = $this->htmlToText($description);

        $this->description = $description;

        return $this;
    }

    public function setLanguage(?string $language): self
    {
        if (! $language) {
            $language = 'unknown';
        }

        $this->language = $language;

        return $this;
    }

    public function setRights(?string $rights): self
    {
        $rights = Str::limit($rights, 250);

        $this->rights = $rights;

        return $this;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        $isValidDate = (bool) strtotime($date);

        if ($isValidDate) {
            $releasedOn = new DateTime(
                datetime: $this->date,
                timezone: new DateTimeZone('UTC'),
            );
            $this->setReleasedOn($releasedOn);
        }

        return $this;
    }

    public function setReleasedOn(DateTime $releasedOn): self
    {
        $this->releasedOn = $releasedOn;

        return $this;
    }

    public function setCover(?BookEntityCover $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function setFile(BookFileReader $file): self
    {
        $this->file = BookEntityFile::make($file);

        return $this;
    }

    public function setExtra(): self
    {
        $this->extra = BookEntityExtra::make($this);

        return $this;
    }

    /**
     * Set the value of authors.
     *
     * @param  BookEntityAuthor[]  $authors
     */
    public function setAuthors(?array $authors): self
    {
        if (empty($authors)) {
            return $this;
        }

        $items = [];

        foreach ($authors as $author) {
            if (! empty($author->name())) {
                $items[] = $author;
            }
        }

        $this->authors = $items;

        return $this;
    }

    /**
     * Set the value of contributor.
     */
    public function setContributor(?string $contributor): self
    {
        $this->contributor = $contributor;

        return $this;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Set the value of identifiers.
     *
     * @param  BookEntityIdentifier[]  $identifiers
     */
    public function setIdentifiers(?array $identifiers): self
    {
        if (empty($identifiers)) {
            return $this;
        }

        $this->identifiers = $identifiers;

        return $this;
    }

    /**
     * Set the value of tags.
     *
     * @param  string[]  $tags
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function setPageCount(?int $pageCount): self
    {
        if ($pageCount > 0) {
            $this->pageCount = $pageCount;
        }

        return $this;
    }

    /**
     * Strip HTML tags.
     */
    private function htmlToText(?string $html, ?array $allow = ['br', 'p', 'ul', 'li']): ?string
    {
        if (! $html) {
            return null;
        }

        $text = str_replace("\n", '', $html); // remove break line
        $text = trim(strip_tags($text, $allow)); // remove html tags and trim

        $regex = '@(https?://([-\\w\\.]+[-\\w])+(:\\d+)?(/([\\w/_\\.#-]*(\\?\\S+)?[^\\.\\s])?).*$)@';
        $text = preg_replace($regex, ' ', $text); // remove links
        $text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $text); // remove style

        return trim($text);
    }

    public function toArray(): array
    {
        $authors = [];

        foreach ($this->authors as $author) {
            $authors[] = $author->toArray();
        }

        $identifiers = [];

        foreach ($this->identifiers as $identifier) {
            $identifiers[] = $identifier->toArray();
        }

        return [
            'title' => $this->title,
            'serie' => $this->serie,
            'volume' => $this->volume,
            'description' => $this->description,
            'language' => $this->language,
            'rights' => $this->rights,
            'date' => $this->date,
            'releasedOn' => $this->releasedOn,
            'cover' => $this->cover?->toArray(),
            'file' => $this->file?->toArray(),
            'extra' => $this->extra?->toArray(),
            'authors' => $authors,
            'contributor' => $this->contributor,
            'publisher' => $this->publisher,
            'identifiers' => $identifiers,
            'tags' => $this->tags,
            'pageCount' => $this->pageCount,
        ];
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
