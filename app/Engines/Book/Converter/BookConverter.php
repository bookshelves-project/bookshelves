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
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Library;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Enums\EbookFormatEnum;
use Kiwilan\LaravelNotifier\Facades\Journal;
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
    public static function make(Ebook $ebook, Library $library, ?Book $book = null): self
    {
        $self = new self($ebook);
        $self->book = $book;

        if ($ebook->getFormat() === EbookFormatEnum::AUDIOBOOK) {
            $self->parseAudiobook($library);
        } else {
            $self->parseBook($library);
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

    private function parseBook(Library $library): self
    {
        if ($this->book) {
            $this->checkBook($library);
        } else {
            $this->createBook();
        }

        if (! $this->book) {
            Journal::error('BookConverter: No book found', [
                'ebook' => $this->ebook->toArray(),
            ]);

            return $this;
        }

        if (empty($this->book?->title)) {
            $this->book = null;

            return $this;
        }

        $this->syncLibrary($library);
        $this->syncAuthors();
        $this->syncTags();
        $this->syncPublisher();
        $this->syncLanguage();
        $this->syncSerie($library);
        $this->syncIdentifiers();
        $this->syncCover();

        return $this;
    }

    private function parseAudiobook(Library $library): self
    {
        $authors = array_map(fn ($author) => $author->getName(), $this->ebook->getAuthors());
        $language = $this->ebook->getLanguage();

        if (! $language) {
            Journal::warning('BookConverter: No language found for '.$this->ebook->getTitle(), [
                'ebook' => $this->ebook->toArray(),
            ]);
        }

        $this->audiobook = Audiobook::query()->create([
            'title' => $this->ebook->getTitle(),
            'slug' => $this->ebook->getMetaTitle()->getSeriesSlug(),
            'track_title' => $this->ebook->getExtra('audio_title'),
            'subtitle' => $this->ebook->getExtra('subtitle'),
            'authors' => $authors,
            'author_main' => $authors[0] ?? null,
            'narrators' => $this->ebook->getExtra('narrators'),
            'description' => $this->ebook->getDescription(),
            'publisher' => $this->ebook->getPublisher(),
            'publish_date' => $this->ebook->getPublishDate(),
            'language' => $language,
            'tags' => $this->ebook->getTags(),
            'serie' => $this->ebook->getSeries(),
            'volume' => $this->getVolume(),
            'format' => $this->ebook->getFormat(),
            'track_number' => $this->ebook->getExtra('track_number'),
            'comment' => $this->ebook->getExtra('comment'),
            'creation_date' => $this->ebook->getExtra('creation_date'),
            'composer' => $this->ebook->getExtra('composer'),
            'disc_number' => $this->ebook->getExtra('disc_number'),
            'is_compilation' => $this->ebook->getExtra('is_compilation'),
            'encoding' => $this->ebook->getExtra('encoding'),
            'lyrics' => $this->ebook->getExtra('lyrics'),
            'stik' => $this->ebook->getExtra('stik'),
            'duration' => $this->ebook->getExtra('duration'),
            'chapters' => $this->ebook->getExtra('chapters'),
            'physical_path' => $this->ebook->getPath(),
            'basename' => $this->ebook->getBasename(),
            'extension' => $this->ebook->getExtension(),
            'mime_type' => mime_content_type($this->ebook->getPath()),
            'size' => $this->ebook->getSize(),
            'added_at' => $this->ebook->getCreatedAt(),
        ]);

        $this->audiobook->library()->associate($library);
        $this->audiobook->saveQuietly();

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

        return storage_path("app/audiobooks/{$name}");
    }

    private function syncLibrary(Library $library): self
    {
        $this->book->library()->associate($library);
        $this->book->saveQuietly();

        return $this;
    }

    private function syncAuthors(): self
    {
        $authors = AuthorModule::toCollection($this->ebook->getAuthors());
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

    private function syncSerie(Library $library): self
    {
        $serie = SerieModule::toModel($this->ebook, $library)->associate($this->book);
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

    private function getVolume(): ?string
    {
        if ($this->ebook->getVolume() === null) {
            return null;
        }

        $volume = (string) $this->ebook->getVolume();
        if ($volume === '0') {
            $volume = 0;
        } else {
            $volume = floatval($volume);
        }

        return strval($volume);
    }

    private function createBook(): self
    {
        // split sliders books, audiobooks, comics, manga and series split at home
        // find duplicate authors
        // find duplicates series like A comme Association (multiple authors)
        $identifiers = IdentifierModule::toCollection($this->ebook);

        $isEpub = $this->ebook->getParser()->isEpub();
        $timestamp = $this->ebook->getCreatedAt();

        if ($isEpub) {
            $calibre_timestamp = $this->ebook->getParser()->getEpub()?->getOpf()?->getMetaItem('calibre:timestamp');
            if ($calibre_timestamp) {
                $timestamp = new DateTime($calibre_timestamp->getContents());
            }
        }

        if (! $this->ebook->getTitle()) {
            Journal::error('BookConverter: No title found', [
                'ebook' => $this->ebook->toArray(),
            ]);

            return $this;
        }

        if (! $this->ebook->getMetaTitle()) {
            Journal::error('BookConverter: No meta title found', [
                'ebook' => $this->ebook->toArray(),
            ]);

            return $this;
        }

        $this->book = new Book([
            'title' => $this->ebook->getTitle(),
            'slug' => $this->ebook->getMetaTitle()->getSlug(),
            'contributor' => $this->ebook->getExtra('contributor'),
            'released_on' => $this->ebook->getPublishDate()?->format('Y-m-d'),
            'description' => $this->ebook->getDescription(2000),
            'rights' => $this->ebook->getCopyright(255),
            'volume' => $this->getVolume(),
            'format' => BookFormatEnum::fromExtension($this->ebook->getExtension()),
            'page_count' => $this->ebook->getPagesCount(),
            'physical_path' => $this->ebook->getPath(),
            'extension' => $this->ebook->getExtension(),
            'mime_type' => mime_content_type($this->ebook->getPath()),
            'size' => $this->ebook->getSize(),
            'isbn10' => $identifiers->get('isbn10') ?? null,
            'isbn13' => $identifiers->get('isbn13') ?? null,
            'identifiers' => $identifiers->toArray(),
            'added_at' => $timestamp,
        ]);

        Book::withoutSyncingToSearch(function () {
            $this->book->save();
        });

        return $this;
    }

    private function checkBook(Library $library): self
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

        if ($this->book->library === null) {
            $this->book->library_id = $library->id;
        }

        return $this;
    }
}
