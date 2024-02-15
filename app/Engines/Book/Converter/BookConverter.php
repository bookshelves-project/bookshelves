<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\Converter\Modules\AuthorModule;
use App\Engines\Book\Converter\Modules\CoverModule;
use App\Engines\Book\Converter\Modules\IdentifierModule;
use App\Engines\Book\Converter\Modules\LanguageModule;
use App\Engines\Book\Converter\Modules\PublisherModule;
use App\Engines\Book\Converter\Modules\SerieModule;
use App\Engines\Book\Converter\Modules\TagModule;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Models\Audiobook;
use App\Models\Book;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Enums\EbookFormatEnum;
use Kiwilan\Steward\Utils\Process;

/**
 * Create or improve a `Book` and relations.
 */
class BookConverter
{
    protected function __construct(
        protected Ebook $ebook,
        protected ?Book $book = null,
        protected ?Audiobook $audiobook = null,
    ) {
    }

    /**
     * Set Book from Ebook.
     */
    public static function make(Ebook $ebook, BookTypeEnum $type, ?Book $book = null): self
    {
        $self = new self($ebook);

        if ($ebook->getFormat() === EbookFormatEnum::AUDIOBOOK) {
            $self->parseAudiobook();
        } else {
            $self->parseBook($type, $book);
        }

        return $self;
    }

    /**
     * Select the most used language in the author books.
     *
     * @param  Collection<int, \App\Models\Book>  $books
     */
    public static function selectLang(Collection $books): string
    {
        $languages = [];
        foreach ($books as $book) {
            $book->load('language');
            if (! $book->language) {
                continue;
            }
            if (array_key_exists($book->language->slug, $languages)) {
                $languages[$book->language->slug]++;
            } else {
                $languages[$book->language->slug] = 1;
            }
        }

        $lang = 'en';
        if (count($languages) > 0) {
            $lang = array_search(max($languages), $languages);
        }

        return $lang;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    private function parseBook(BookTypeEnum $type, ?Book $book): self
    {
        if ($book) {
            $this->checkBook($type);
        }

        $identifiers = IdentifierModule::toCollection($this->ebook);

        if (! $book) {
            $this->book = new Book([
                'title' => $this->ebook->getTitle(),
                'slug' => $this->ebook->getMetaTitle()->getSlug(),
                'contributor' => $this->ebook->getExtra('contributor'),
                'released_on' => $this->ebook->getPublishDate()?->format('Y-m-d'),
                'description' => $this->ebook->getDescription(2000),
                'rights' => $this->ebook->getCopyright(255),
                'volume' => $this->ebook->getVolume(),
                'format' => BookFormatEnum::fromExtension($this->ebook->getExtension()),
                'type' => $type,
                'page_count' => $this->ebook->getPagesCount(),
                'physical_path' => $this->ebook->getPath(),
                'extension' => $this->ebook->getExtension(),
                'mime_type' => mime_content_type($this->ebook->getPath()),
                'size' => $this->ebook->getSize(),
                'isbn10' => $identifiers->get('isbn10') ?? null,
                'isbn13' => $identifiers->get('isbn13') ?? null,
                'identifiers' => $identifiers->toArray(),
                'added_at' => $this->ebook->getCreatedAt(),
            ]);

            Book::withoutSyncingToSearch(function () {
                $this->book->save();
            });
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

        return $this;
    }

    private function parseAudiobook(): self
    {
        $authors = [];
        if (str_contains($this->ebook->getPublisher(), ',')) {
            $authors = explode(',', $this->ebook->getPublisher());
        } elseif (str_contains($this->ebook->getPublisher(), ' & ')) {
            $authors = explode(' & ', $this->ebook->getPublisher());
        } else {
            $authors[] = $this->ebook->getPublisher();
        }
        $authors = array_map(fn ($author) => trim($author), $authors);

        $this->audiobook = Audiobook::query()->create([
            'title' => $this->ebook->getTitle(),
            'slug' => $this->ebook->getMetaTitle()->getSeriesSlug(),
            'authors' => $authors,
            'author_main' => $authors[0] ?? null,
            'narrators' => array_map(fn ($author) => $author->getName(), $this->ebook->getAuthors()),
            'description' => $this->ebook->getDescription(),
            'publish_date' => $this->ebook->getPublishDate(),
            'language' => $this->ebook->getLanguage(),
            'tags' => $this->ebook->getTags(),
            'serie' => $this->ebook->getSeries(),
            'volume' => $this->ebook->getVolume(),
            'format' => $this->ebook->getFormat(),
            'track_number' => $this->ebook->getExtra('trackNumber'),
            'comment' => $this->ebook->getExtra('comment'),
            'creation_date' => $this->ebook->getExtra('creationDate'),
            'composer' => $this->ebook->getExtra('composer'),
            'disc_number' => $this->ebook->getExtra('discNumber'),
            'is_compilation' => $this->ebook->getExtra('isCompilation'),
            'encoding' => $this->ebook->getExtra('encoding'),
            'lyrics' => $this->ebook->getExtra('lyrics'),
            'stik' => $this->ebook->getExtra('stik'),
            'duration' => $this->ebook->getExtra('duration'),
            'physical_path' => $this->ebook->getPath(),
            'basename' => $this->ebook->getBasename(),
            'extension' => $this->ebook->getExtension(),
            'mime_type' => mime_content_type($this->ebook->getPath()),
            'size' => $this->ebook->getSize(),
            'added_at' => $this->ebook->getCreatedAt(),
        ]);

        $cover = $this->ebook->getCover()->getContents();
        if ($cover) {
            $path = BookConverter::audiobookCoverPath($this->audiobook);
            file_put_contents($path, $cover);
        }

        return $this;
    }

    public static function audiobookCoverPath(Audiobook $audiobook): string
    {
        $name = "audiobook-{$audiobook->id}.jpg";

        return storage_path("app/cache/{$name}");
    }

    private function syncAuthors(): self
    {
        $authors = AuthorModule::toCollection($this->ebook);
        if ($authors->isEmpty()) {
            return $this;
        }

        Book::withoutSyncingToSearch(function () use ($authors) {
            $this->book->authorMain()->associate($authors->first());
            $this->book?->authors()->sync($authors->pluck('id'));
        });

        return $this;
    }

    private function syncTags(): self
    {
        $tags = TagModule::toCollection($this->ebook);
        if ($tags->isEmpty()) {
            return $this;
        }

        Book::withoutSyncingToSearch(function () use ($tags) {
            $this->book?->tags()->sync($tags->pluck('id'));
        });

        return $this;
    }

    private function syncPublisher(): self
    {
        $publisher = PublisherModule::toModel($this->ebook);
        if (! $publisher) {
            return $this;
        }

        Book::withoutSyncingToSearch(function () use ($publisher) {
            $this->book?->publisher()->associate($publisher);
            $this->book?->save();
        });

        return $this;
    }

    private function syncLanguage(): self
    {
        $language = LanguageModule::make($this->ebook->getLanguage());

        Book::withoutSyncingToSearch(function () use ($language) {
            $this->book?->language()->associate($language);
            $this->book?->save();
        });

        return $this;
    }

    private function syncSerie(BookTypeEnum $type): self
    {
        $serie = SerieModule::toModel($this->ebook, $type)->associate($this->book);
        if (! $serie) {
            return $this;
        }

        Book::withoutSyncingToSearch(function () use ($serie) {
            $this->book?->serie()->associate($serie);
            $this->book?->save();
        });

        return $this;
    }

    private function syncIdentifiers(): self
    {
        $identifiers = IdentifierModule::toCollection($this->ebook);
        if ($identifiers->isEmpty()) {
            return $this;
        }

        Book::withoutSyncingToSearch(function () use ($identifiers) {
            $this->book->isbn10 = $identifiers->get('isbn10') ?? null;
            $this->book->isbn13 = $identifiers->get('isbn13') ?? null;
            $this->book->identifiers = $identifiers->toArray();
            $this->book->save();
        });

        return $this;
    }

    private function syncCover(): void
    {
        Process::memoryPeek(function () {
            CoverModule::make($this->ebook, $this->book);
        }, maxMemory: 3);
    }

    private function checkBook(BookTypeEnum $type): self
    {
        if (! $this->book) {
            return $this;
        }

        if (! $this->book->slug && $this->ebook->getSeries() && ! $this->book->serie) {
            $this->book->slug = $this->ebook->getMetaTitle()->getSlug();
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

        if ($this->book->type === null) {
            $this->book->type = $type;
        }

        return $this;
    }
}
