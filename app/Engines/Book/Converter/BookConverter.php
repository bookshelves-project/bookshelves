<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\BookUtils;
use App\Engines\Book\Converter\Modules\AuthorModule;
use App\Engines\Book\Converter\Modules\CoverModule;
use App\Engines\Book\Converter\Modules\IdentifierModule;
use App\Engines\Book\Converter\Modules\LanguageModule;
use App\Engines\Book\Converter\Modules\PublisherModule;
use App\Engines\Book\Converter\Modules\SerieModule;
use App\Engines\Book\Converter\Modules\TagModule;
use App\Enums\BookFormatEnum;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\File;
use DateTime;
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
        protected File $file,
        protected ?Book $book = null,
        protected ?AudiobookTrack $track = null,
        protected bool $isAudiobookAndBookExists = false,
    ) {}

    /**
     * Set Book from Ebook.
     */
    public static function make(Ebook $ebook, File $file): self
    {
        $self = new self($ebook, $file);
        $self->parseBook();

        return $self;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    public function isAudiobookAndBookExists(): bool
    {
        return $this->isAudiobookAndBookExists;
    }

    private function parseBook(): self
    {
        $this->book = $this->createBook();

        if ($this->ebook->getFormat() === EbookFormatEnum::AUDIOBOOK) {
            $this->parseAudiobookTrack();
        }

        if ($this->isAudiobookAndBookExists) {
            Journal::debug('BookConverter: Found existing audiobook, syncing with book', [
                'ebook' => $this->book->title,
            ]);

            return $this;
        }

        if (! $this->book) {
            Journal::error('BookConverter: No book found', [
                'ebook' => $this->ebook->toArray(),
            ]);

            return $this;
        }

        $this->syncLibrary();
        $this->syncAuthors();
        $this->syncTags();
        $this->syncPublisher();
        $this->syncLanguage();
        $this->syncSerie();
        $this->syncIdentifiers();
        $this->syncCover();

        return $this;
    }

    private function parseAudiobookTrack(): self
    {
        $authors = array_map(fn ($author) => $author->getName(), $this->ebook->getAuthors());
        $language = $this->ebook->getLanguage();

        if (! $language) {
            Journal::warning('BookConverter: No language found for '.$this->ebook->getTitle(), [
                'ebook' => $this->ebook->toArray(),
            ]);
        }

        $this->track = new AudiobookTrack([
            'title' => $this->ebook->getTitle(),
            'slug' => $this->ebook->getMetaTitle()->getSlug(),
            'track_title' => $this->ebook->getExtra('audio_title'),
            'subtitle' => $this->ebook->getExtra('subtitle'),
            'authors' => $authors,
            'narrators' => $this->ebook->getExtra('narrators'),
            'description' => $this->ebook->getDescriptionAdvanced()->toHtml(2000),
            'publisher' => $this->ebook->getPublisher(),
            'publish_date' => $this->ebook->getPublishDate(),
            'language' => $language,
            'tags' => $this->ebook->getTags(),
            'serie' => $this->ebook->getSeries(),
            'volume' => $this->getVolume(),
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
            'added_at' => $this->ebook->getCreatedAt(),
        ]);

        $this->track->library()->associate($this->file->library);
        $this->track->file()->associate($this->file);
        // $this->track->book()->associate($this->book);
        $this->track->saveQuietly();

        return $this;
    }

    private function syncLibrary(): self
    {
        $this->book->library()->associate($this->file->library);
        $this->book->saveNoSearch();

        return $this;
    }

    private function syncAuthors(): self
    {
        $authors = AuthorModule::make($this->ebook->getAuthors());
        if ($authors->isEmpty()) {
            Journal::warning("BookConverter: No authors found for {$this->book->title}", [
                'ebook' => $this->ebook->toArray(),
            ]);

            return $this;
        }

        $this->book->authorMain()->associate($authors->first());
        foreach ($authors as $author) {
            $this->book->authors()->attach($author->id);
        }
        $this->book->saveNoSearch();

        return $this;
    }

    private function syncTags(): self
    {
        $tags = TagModule::toCollection($this->ebook);
        if ($tags->isEmpty()) {
            return $this;
        }

        Book::withoutSyncingToSearch(function () use ($tags) {
            $this->book->tags()->sync($tags->pluck('id'));
        });

        return $this;
    }

    private function syncPublisher(): self
    {
        $publisher = PublisherModule::toModel($this->ebook);
        if (! $publisher) {
            return $this;
        }

        $this->book->publisher()->associate($publisher);
        $this->book->saveNoSearch();

        return $this;
    }

    private function syncLanguage(): self
    {
        $lang = $this->ebook->getLanguage();
        if ($this->ebook->getFormat() === EbookFormatEnum::AUDIOBOOK) {
            $lang = BookUtils::audiobookParseLang($this->ebook->getLanguage(), $this->ebook->getExtra('comment'));
        }
        $language = LanguageModule::make($lang);

        $this->book->language()->associate($language);
        $this->book->saveNoSearch();

        return $this;
    }

    private function syncSerie(): self
    {
        $serie = SerieModule::make($this->ebook, $this->book);
        if (! $serie) {
            return $this;
        }

        $this->book->serie()->associate($serie);
        $this->book->saveNoSearch();

        return $this;
    }

    private function syncIdentifiers(): self
    {
        $identifiers = IdentifierModule::toCollection($this->ebook);
        if ($identifiers->isEmpty()) {
            return $this;
        }

        $this->book->isbn10 = $identifiers->get('isbn10') ?? null;
        $this->book->isbn13 = $identifiers->get('isbn13') ?? null;
        $this->book->identifiers = $identifiers->toArray();
        $this->book->saveNoSearch();

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

    private function createBook(): ?Book
    {
        $identifiers = IdentifierModule::toCollection($this->ebook);

        $isEpub = $this->ebook->getParser()?->isEpub();
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

            return null;
        }

        if (! $this->ebook->getMetaTitle()) {
            Journal::error('BookConverter: No meta title found', [
                'ebook' => $this->ebook->toArray(),
            ]);

            return null;
        }

        if ($this->ebook->getFormat() === EbookFormatEnum::AUDIOBOOK) {
            $title = BookUtils::audiobookParseTitle($this->ebook->getTitle());

            $isExists = Book::query()
                ->where('title', $title)
                ->where('library_id', $this->file->library_id)
                ->first();

            if ($isExists) {
                /** @var Book $isExists */
                $this->isAudiobookAndBookExists = true;
                $isExists->audiobook_chapters = array_merge($isExists->audiobook_chapters, $this->ebook->getExtra('chapters'));
                $isExists->saveNoSearch();

                return $isExists;
            }

            $book = new Book([
                'title' => $title,
                'slug' => $this->ebook->getMetaTitle()->getSlug(),
                'format' => BookFormatEnum::audio,
                'contributor' => $this->ebook->getExtra('encoding'),
                'released_on' => $this->ebook->getPublishDate(),
                'description' => $this->ebook->getDescriptionAdvanced()->toHtml(2000),
                'audiobook_narrators' => $this->ebook->getExtra('narrators'),
                'audiobook_chapters' => $this->ebook->getExtra('chapters'),
                'is_audiobook' => true,
                'rights' => $this->ebook->getExtra('encoding'),
                'volume' => $this->getVolume(),
                'added_at' => $this->ebook->getCreatedAt(),
            ]);
        } else {
            $book = new Book([
                'title' => $this->ebook->getTitle(),
                'slug' => $this->ebook->getMetaTitle()->getSlug(),
                'contributor' => $this->ebook->getExtra('contributor'),
                'released_on' => $this->ebook->getPublishDate()?->format('Y-m-d'),
                'description' => $this->ebook->getDescriptionAdvanced()->toHtml(2000),
                'rights' => $this->ebook->getCopyright(255),
                'volume' => $this->getVolume(),
                'page_count' => $this->ebook->getPagesCount(),
                'isbn10' => $identifiers->get('isbn10') ?? null,
                'isbn13' => $identifiers->get('isbn13') ?? null,
                'identifiers' => $identifiers->toArray(),
                'added_at' => $timestamp,
            ]);
        }

        $format = BookFormatEnum::fromExtension($this->file->extension);

        if (! array_key_exists($format->value, BookFormatEnum::toArray())) {
            Journal::warning("BookConverter: format not valid {$this->file->path}");

            return null;
        }

        if ($format->value === BookFormatEnum::unknown->value) {
            Journal::warning("BookConverter: unknown format {$this->file->path}");

            return null;
        }

        $book->format = $format;
        $book->file()->associate($this->file);

        try {
            $book->saveNoSearch();
        } catch (\Throwable $th) {
            if ($this->isAudiobookAndBookExists) {
                // book exists and saved in parallel
                $this->book = Book::query()
                    ->where('slug', $book->slug)
                    ->where('library_id', $this->file->library_id)
                    ->first();
                $this->isAudiobookAndBookExists = true;
            }

            Journal::error("BookConverter: failed to save book {$this->file->path}", [
                'exception' => $th,
            ]);
        }

        return $book;
    }
}
