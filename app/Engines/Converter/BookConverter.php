<?php

namespace App\Engines\Converter;

use App\Engines\Converter\Modules\AuthorConverter;
use App\Engines\Converter\Modules\CoverConverter;
use App\Engines\Converter\Modules\FileConverter;
use App\Engines\Converter\Modules\IdentifiersConverter;
use App\Engines\Converter\Modules\LanguageConverter;
use App\Engines\Converter\Modules\PublisherConverter;
use App\Engines\Converter\Modules\SerieConverter;
use App\Engines\Converter\Modules\TagConverter;
use App\Engines\Parser\Models\BookEntity;
use App\Models\Book;
use Illuminate\Support\Carbon;

/**
 * Create or improve a `Book` and relations.
 */
class BookConverter
{
    protected function __construct(
        protected BookEntity $entity,
        protected ?Book $book = null,
    ) {
    }

    /**
     * Set Book from BookEntity.
     */
    public static function make(BookEntity $entity, ?Book $book = null): self
    {
        $self = new self($entity);

        if ($book) {
            $self->checkBook();
        }

        if (! $book) {
            $self->book = Book::firstOrCreate([
                'title' => $self->entity->title(),
                'slug' => $self->entity->extra()->titleSlugLang(),
                'slug_sort' => $self->entity->extra()->titleSerieSort(),
                'contributor' => $self->entity->contributor(),
                'released_on' => $self->entity->releasedOn(),
                'description' => $self->entity->description(),
                'rights' => $self->entity->rights(),
                'volume' => $self->entity->volume(),
                'type' => $self->entity->file()->type(),
                'page_count' => $self->entity->pageCount(),
                'physical_path' => $self->entity->file()->path(),
            ]);
        }

        $self->setAuthors();
        $self->setTags();
        $self->setPublisher();
        $self->setLanguage();
        $self->setSerie();
        $self->setIdentifiers();
        $self->setCover();
        $self->setFile();

        return $self;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    private function setAuthors(): self
    {
        $authors = AuthorConverter::toCollection($this->entity);
        $this->book->authors()->sync($authors->pluck('id'));

        return $this;
    }

    private function setTags(): self
    {
        $tags = TagConverter::toCollection($this->entity);

        if ($tags) {
            $this->book->tags()->sync($tags->pluck('id'));
        }

        return $this;
    }

    private function setPublisher(): self
    {
        $publisher = PublisherConverter::toModel($this->entity);
        $this->book->publisher()->associate($publisher);
        $this->book->save();

        return $this;
    }

    private function setLanguage(): self
    {
        $language = LanguageConverter::toModel($this->entity);
        $this->book->language()->associate($language);
        $this->book->save();

        return $this;
    }

    private function setSerie(): self
    {
        $serie = SerieConverter::toModel($this->entity)
            ->associate($this->book)
        ;

        if ($serie) {
            $this->book->serie()->associate($serie);
            $this->book->save();
        }

        return $this;
    }

    private function setIdentifiers(): self
    {
        $identifiers = IdentifiersConverter::toCollection($this->entity);

        $this->book->isbn10 = $identifiers->get('isbn10') ?? null;
        $this->book->isbn13 = $identifiers->get('isbn13') ?? null;
        $this->book->identifiers = $identifiers;
        $this->book->save();

        return $this;
    }

    private function setCover(): self
    {
        $cover = CoverConverter::make($this->entity, $this->book);

        return $this;
    }

    private function setFile()
    {
        $file = FileConverter::make($this->entity, $this->book);
    }

    private function checkBook(): self
    {
        if (! $this->book) {
            return $this;
        }

        if (! $this->book->slug_sort && $this->entity->serie() && ! $this->book->serie) {
            $this->book->slug_sort = $this->entity->extra()->titleSerieSort();
        }

        if (! $this->book->contributor) {
            $this->book->contributor = $this->entity->contributor();
        }

        if (! $this->book->released_on) {
            $this->book->released_on = Carbon::parse($this->entity->releasedOn());
        }

        if (! $this->book->rights) {
            $this->book->rights = $this->entity->rights();
        }

        if (! $this->book->description) {
            $this->book->description = $this->entity->description();
        }

        if (! $this->book->volume) {
            $this->book->volume = $this->entity->volume();
        }

        if (null === $this->book->type) {
            $this->book->type = $this->entity->file()->type();
        }

        return $this;
    }

    // public static function setDescription(Book $book, ?string $language_slug, ?string $description): Book
    // {
    //     if (null !== $description && null !== $language_slug && '' === $book->getTranslation('description', $language_slug)) {
    //         $book->setTranslation('description', $language_slug, $description);
    //     }

    //     return $book;
    // }
}
