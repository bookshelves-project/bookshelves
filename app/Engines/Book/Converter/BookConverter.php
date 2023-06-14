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
    public static function make(Ebook $ebook, BookTypeEnum $type, ?Book $book = null): self
    {
        $self = new self($ebook);

        if ($book) {
            $self->checkBook($type);
        }

        if (! $book) {
            $rights = $self->ebook->copyright();
            $description = $self->ebook->description();

            if (strlen($description) > 2000) {
                $description = substr($description, 0, 2000).'...';
            }

            $self->book = Book::firstOrCreate([
                'title' => $self->ebook->title(),
                'slug' => $self->ebook->metaTitle()->slugLang(),
                'slug_sort' => $self->ebook->metaTitle()->slugSortWithSerie(),
                'contributor' => $self->ebook->extrasExtract('contributor'),
                'released_on' => $self->ebook->publishDate(),
                'description' => $description,
                'rights' => strlen($rights) > 255 ? substr($rights, 0, 255) : $rights,
                'volume' => $self->ebook->volume(),
                'type' => $type,
                'page_count' => $self->ebook->pagesCount(),
                'physical_path' => $ebook->path(),
            ]);
        }

        if (empty($self->book?->title)) {
            Book::destroy($self->book?->id);

            return $self;
        }

        $self->setAuthors();
        $self->setTags();
        $self->setPublisher();
        $self->setLanguage();
        $self->setSerie($type);
        $self->setIdentifiers();
        $self->setCover($ebook);
        $self->setFile($ebook);

        $self->book->authorMain()->associate($self->book->authors->first());
        $self->book->save();

        $serie = $self->book->serie;

        if ($serie) {
            $serie->authorMain()->associate($self->book->authorMain);
            $serie->authors()->sync($self->book->authors->pluck('id'));
            $serie->save();
        }

        return $self;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    private function setAuthors(): self
    {
        $authors = AuthorConverter::toCollection($this->ebook);
        $this->book?->authors()->sync($authors->pluck('id'));

        return $this;
    }

    private function setTags(): self
    {
        $tags = TagConverter::toCollection($this->ebook);

        if ($tags->isNotEmpty()) {
            $this->book?->tags()->sync($tags->pluck('id'));
        }

        return $this;
    }

    private function setPublisher(): self
    {
        $publisher = PublisherConverter::toModel($this->ebook);
        $this->book?->publisher()->associate($publisher);
        $this->book?->save();

        return $this;
    }

    private function setLanguage(): self
    {
        $language = LanguageConverter::toModel($this->ebook);
        $this->book?->language()->associate($language);
        $this->book?->save();

        return $this;
    }

    private function setSerie(BookTypeEnum $type): self
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

    private function setIdentifiers(): self
    {
        $identifiers = IdentifiersConverter::toCollection($this->ebook);

        $this->book->isbn10 = $identifiers->get('isbn10') ?? null;
        $this->book->isbn13 = $identifiers->get('isbn13') ?? null;
        $this->book->identifiers = $identifiers;
        $this->book->save();

        return $this;
    }

    private function setCover(Ebook $ebook): void
    {
        CoverConverter::make($ebook, $this->book);
    }

    private function setFile(Ebook $ebook): void
    {
        FileConverter::make($ebook, $this->book);
    }

    private function checkBook(BookTypeEnum $type): self
    {
        if (! $this->book) {
            return $this;
        }

        if (! $this->book->slug_sort && $this->ebook->series() && ! $this->book->serie) {
            $this->book->slug_sort = $this->ebook->metaTitle()->serieSlugSort();
        }

        if (! $this->book->contributor) {
            $this->book->contributor = $this->ebook->extrasExtract('contributor') ?? null;
        }

        if (! $this->book->released_on) {
            $this->book->released_on = Carbon::parse($this->ebook->publishDate());
        }

        if (! $this->book->rights) {
            $this->book->rights = $this->ebook->copyright();
        }

        if (! $this->book->description) {
            $this->book->description = $this->ebook->description();
        }

        if (! $this->book->volume) {
            $this->book->volume = $this->ebook->volume();
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
