<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\Converter\Modules\AuthorConverter;
use App\Engines\Book\Converter\Modules\CoverConverter;
use App\Engines\Book\Converter\Modules\FileConverter;
use App\Engines\Book\Converter\Modules\IdentifiersConverter;
use App\Engines\Book\Converter\Modules\LanguageConverter;
use App\Engines\Book\Converter\Modules\PublisherConverter;
use App\Engines\Book\Converter\Modules\SerieConverter;
use App\Engines\Book\Converter\Modules\TagConverter;
use App\Enums\BookTypeEnum;
use App\Models\Book;
use Illuminate\Support\Carbon;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Services\ProcessService;

/**
 * Create or improve a `Book` and relations.
 */
class BookConverter
{
    protected function __construct(
        protected Ebook $ebook,
        protected ?Book $book = null,
    ) {
    }

    /**
     * Set Book from Ebook.
     */
    public static function make(Ebook $ebook, BookTypeEnum $type, Book $book = null): self
    {
        $self = new self($ebook);
        $self->parse($type, $book);

        return $self;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    private function parse(BookTypeEnum $type, ?Book $book): self
    {
        if ($book) {
            $this->checkBook($type);
        }

        $identifiers = IdentifiersConverter::toCollection($this->ebook);

        if (! $book) {
            $this->book = new Book([
                'title' => $this->ebook->getTitle(),
                'uuid' => uniqid(),
                'slug' => $this->ebook->getMetaTitle()->getSlugLang(),
                'slug_sort' => $this->ebook->getMetaTitle()->getSlugSortWithSerie(),
                'contributor' => $this->ebook->getExtra('contributor'),
                'released_on' => $this->ebook->getPublishDate()?->format('Y-m-d'),
                'description' => $this->ebook->getDescription(2000),
                'rights' => $this->ebook->getCopyright(255),
                'volume' => $this->ebook->getVolume(),
                'type' => $type,
                'page_count' => $this->ebook->getPagesCount(),
                'physical_path' => $this->ebook->getPath(),
                'isbn10' => $identifiers->get('isbn10') ?? null,
                'isbn13' => $identifiers->get('isbn13') ?? null,
                'identifiers' => json_encode($identifiers),
            ]);
            $this->book->save();
        }

        if (empty($this->book?->title)) {
            $this->book = null;

            return $this;
        }

        $this->syncAuthors();
        $this->syncTags();
        $this->syncPublisher();
        $this->syncLanguage();
        $this->syncSerie($type);
        $this->syncIdentifiers();
        $this->syncCover();

        if (config('bookshelves.local.copy')) {
            $this->copyFile();
        }

        return $this;
    }

    private function syncAuthors(): self
    {
        $authors = AuthorConverter::toCollection($this->ebook);

        if ($authors->isNotEmpty()) {
            $this->book->authorMain()->associate($authors->first());
            $this->book?->authors()->sync($authors->pluck('id'));
        }

        return $this;
    }

    private function syncTags(): self
    {
        $tags = TagConverter::toCollection($this->ebook);

        if ($tags->isNotEmpty()) {
            $this->book?->tags()->sync($tags->pluck('id'));
        }

        return $this;
    }

    private function syncPublisher(): self
    {
        $publisher = PublisherConverter::toModel($this->ebook);
        $this->book?->publisher()->associate($publisher);
        $this->book?->save();

        return $this;
    }

    private function syncLanguage(): self
    {
        $language = LanguageConverter::toModel($this->ebook);
        $this->book?->language()->associate($language);
        $this->book?->save();

        return $this;
    }

    private function syncSerie(BookTypeEnum $type): self
    {
        $serie = SerieConverter::toModel($this->ebook, $type)
            ->associate($this->book)
        ;

        if ($serie) {
            $this->book?->serie()->associate($serie);
            $this->book?->save();
        }

        return $this;
    }

    private function syncIdentifiers(): self
    {
        $identifiers = IdentifiersConverter::toCollection($this->ebook);

        $this->book->isbn10 = $identifiers->get('isbn10') ?? null;
        $this->book->isbn13 = $identifiers->get('isbn13') ?? null;
        $this->book->identifiers = $identifiers;
        $this->book->save();

        return $this;
    }

    private function syncCover(): void
    {
        ProcessService::memoryPeek(function () {
            CoverConverter::make($this->ebook, $this->book);
        }, maxMemory: 3);
    }

    private function copyFile(): void
    {
        FileConverter::make($this->ebook, $this->book);
    }

    private function checkBook(BookTypeEnum $type): self
    {
        if (! $this->book) {
            return $this;
        }

        if (! $this->book->slug_sort && $this->ebook->getSeries() && ! $this->book->serie) {
            $this->book->slug_sort = $this->ebook->getMetaTitle()->getSerieSlugSort();
        }

        if (! $this->book->contributor) {
            $this->book->contributor = $this->ebook->getExtra('contributor') ?? null;
        }

        if (! $this->book->released_on) {
            $this->book->released_on = Carbon::parse($this->ebook->getPublishDate());
        }

        if (! $this->book->rights) {
            $this->book->rights = $this->ebook->getCopyright();
        }

        if (! $this->book->description) {
            $this->book->description = $this->ebook->getDescription();
        }

        if (! $this->book->volume) {
            $this->book->volume = $this->ebook->getVolume();
        }

        if (null === $this->book->type) {
            $this->book->type = $type;
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
