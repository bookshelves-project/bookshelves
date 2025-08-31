<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\IdentifierModule;
use App\Engines\Library\FileItem;
use App\Enums\BookFormatEnum;
use App\Facades\Bookshelves;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\File;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $file_path,
        public int|string $library_id,
        public string $position,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_item = FileItem::make($this->file_path, $this->library_id, $finfo);
        finfo_close($finfo);

        if (Bookshelves::verbose()) {
            Journal::debug("BookJob: {$this->position} for {$file_item->getBasename()}...");
        }

        $file = $this->convertFileItem($file_item);
        $ebook = Ebook::read($this->file_path);

        if (! $ebook->getTitle()) {
            Journal::warning("No title found for {$file->basename}, trying to read again...");
            $ebook = Ebook::read($this->file_path);
        }

        if (! $ebook->getTitle() || ! $ebook->getMetaTitle()) {
            Journal::error("BookJob: No title or meta title found for {$file->basename}", [
                'ebook' => $ebook->toArray(),
                'exists' => file_exists($this->file_path),
            ]);

            return;
        }

        $identifiers = IdentifierModule::toCollection($ebook);

        /** @var Book */
        $book = Book::withoutSyncingToSearch(function () use ($ebook, $identifiers, $file) {
            return Book::create([
                'title' => $ebook->isAudio()
                    ? BookshelvesUtils::audiobookParseTitle($ebook->getTitle())
                    : $ebook->getTitle(),
                'slug' => $ebook->getMetaTitle()->getSlug(),
                'contributor' => $ebook->isAudio()
                    ? $ebook->getExtra('encoding')
                    : $ebook->getExtra('contributor'),
                'released_on' => $ebook->getPublishDate()?->format('Y-m-d'),
                'has_series' => $ebook->hasSeries(),
                'description' => $ebook->getDescriptionAdvanced()->toHtml(2000),
                'rights' => $ebook->isAudio()
                    ? $ebook->getExtra('encoding')
                    : $ebook->getCopyright(255),
                'volume' => $this->parseVolume($ebook->getVolume()),
                'format' => $ebook->isAudio()
                    ? BookFormatEnum::audio
                    : BookFormatEnum::fromExtension($file->extension),
                'page_count' => $ebook->isAudio()
                    ? null
                    : $ebook->getPagesCount(),
                'isbn10' => $identifiers->get('isbn10') ?? null,
                'isbn13' => $identifiers->get('isbn13') ?? null,
                'identifiers' => $identifiers->toArray(),
                'added_at' => $ebook->getCreatedAt(),
                'calibre_timestamp' => $ebook->isAudio()
                    ? $ebook->getCreatedAt()
                    : $ebook->getParser()->getEpub()?->getOpf()?->getMetaItem('calibre:timestamp')?->getContents(),

                'is_audiobook' => $ebook->isAudio(),
                'audiobook_narrators' => $ebook->isAudio() ? $ebook->getExtra('narrators') : null,
                'audiobook_chapters' => $ebook->isAudio() ? $ebook->getExtra('chapters') : null,
            ]);
        });

        $book->file()->associate($file);
        $book->library()->associate($this->library_id);
        $book->saveNoSearch();

        if ($ebook->isAudio()) {
            $track = $this->handleAudiobookTrack($ebook);
            $track->library()->associate($file->library);
            $track->file()->associate($file);
            $track->book()->associate($book);
            $track->save();
        }

        // serialize authors
        BookshelvesUtils::serialize($book->getIndexAuthorPath(), [$ebook->getAuthorMain(), ...$ebook->getAuthors()]);

        // serialize series
        if ($ebook->hasSeries()) {
            BookshelvesUtils::serialize($book->getIndexSeriePath(), [
                'title' => $ebook->getSeries(),
                'slug' => $ebook->getMetaTitle()->getSeriesSlug(),
                'library_id' => $this->library_id,
            ]);
        }

        // serialize tags
        if (! empty($ebook->getTags())) {
            BookshelvesUtils::serialize($book->getIndexTagPath(), $ebook->getTags());
        }

        // serialize language
        if ($ebook->getLanguage() !== null) {
            BookshelvesUtils::serialize($book->getIndexLanguagePath(), $ebook->getLanguage());
        }

        // serialize publisher
        if ($ebook->getPublisher() !== null) {
            BookshelvesUtils::serialize($book->getIndexPublisherPath(), $ebook->getPublisher());
        }

        // serialize cover
        if ($ebook->hasCover()) {
            BookshelvesUtils::ensureDirectoryExists($book->getIndexCoverPath());
            file_put_contents($book->getIndexCoverPath(), $ebook->getCover()->getContents());
            if (! file_exists($book->getIndexCoverPath())) {
                Journal::error("Failed to recreate cover for book {$file->path}.");
                // ray($ebook)->purple();
            }
        } else {
            $ebook->clearCover();
            Journal::error("Cover not found for book {$file->path}.", [
                'ebook' => $ebook,
            ]);
            // ray($ebook)->purple();
        }

        // serialize ebook
        $ebook->clearCover();
        BookshelvesUtils::serialize($book->getIndexBookPath(), $ebook);
    }

    private function convertFileItem(FileItem $file_item): File
    {
        return File::create([
            'path' => $file_item->getPath(),
            'basename' => $file_item->getBasename(),
            'extension' => $file_item->getExtension(),
            'mime_type' => $file_item->getMimeType(),
            'size' => $file_item->getSize(),
            'date_added' => $file_item->getDateAdded(),
            'library_id' => $this->library_id,
        ]);
    }

    /**
     * Parse volume from `Kiwilan\Ebook\Ebook` volume.
     */
    private function parseVolume(int|float|null $volume): ?string
    {
        if ($volume === null) {
            return null;
        }

        $volume = (string) $volume;
        if ($volume === '0') {
            $volume = 0;
        } else {
            $volume = floatval($volume);
        }

        return strval($volume);
    }

    private function handleAudiobookTrack(Ebook $ebook): AudiobookTrack
    {
        $authors = array_map(fn ($author) => $author->getName(), $ebook->getAuthors());
        $language = $ebook->getLanguage();

        return AudiobookTrack::create([
            'title' => $ebook->getTitle(),
            'slug' => $ebook->getMetaTitle()->getSlug(),
            'track_title' => $ebook->getExtra('audio_title'),
            'subtitle' => $ebook->getExtra('subtitle'),
            'authors' => $authors,
            'narrators' => $ebook->getExtra('narrators'),
            'description' => $ebook->getDescriptionAdvanced()->toHtml(2000),
            'publisher' => $ebook->getPublisher(),
            'publish_date' => $ebook->getPublishDate(),
            'language' => $language,
            'tags' => $ebook->getTags(),
            'serie' => $ebook->getSeries(),
            'volume' => $ebook->getVolume(),
            'track_number' => $ebook->getExtra('track_number'),
            'comment' => $ebook->getExtra('comment'),
            'creation_date' => $ebook->getExtra('creation_date'),
            'composer' => $ebook->getExtra('composer'),
            'disc_number' => $ebook->getExtra('disc_number'),
            'is_compilation' => $ebook->getExtra('is_compilation'),
            'encoding' => $ebook->getExtra('encoding'),
            'lyrics' => $ebook->getExtra('lyrics'),
            'stik' => $ebook->getExtra('stik'),
            'duration' => $ebook->getExtra('duration'),
            'chapters' => $ebook->getExtra('chapters'),
            'added_at' => $ebook->getCreatedAt(),
        ]);
    }
}
