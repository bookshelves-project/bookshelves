<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\IdentifierModule;
use App\Engines\Library\FileItem;
use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\File;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;

class IndexBookJob implements ShouldQueue
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
            Journal::debug("IndexBookJob: {$this->position} for {$file_item->getBasename()}...");
        }

        $file = $this->convertFileItem($file_item);
        $ebook = Ebook::read($this->file_path);

        if (! $ebook->getTitle() || ! $ebook->getMetaTitle()) {
            Journal::error('IndexBookJob: No title or meta title found', [
                'ebook' => $ebook->getPath(),
            ]);

            return;
        }

        $identifiers = IdentifierModule::toCollection($ebook);

        /** @var Book $book */
        $book = Book::create([
            'title' => $ebook->getTitle(),
            'slug' => $ebook->getMetaTitle()->getSlug(),
            'contributor' => $ebook->getExtra('contributor'),
            'released_on' => $ebook->getPublishDate()?->format('Y-m-d'),
            'has_series' => $ebook->hasSeries(),
            'description' => $ebook->getDescriptionAdvanced()->toHtml(2000),
            'rights' => $ebook->getCopyright(255),
            'volume' => $this->parseVolume($ebook->getVolume()),
            'page_count' => $ebook->getPagesCount(),
            'isbn10' => $identifiers->get('isbn10') ?? null,
            'isbn13' => $identifiers->get('isbn13') ?? null,
            'identifiers' => $identifiers->toArray(),
            'added_at' => $ebook->getCreatedAt(),
            'calibre_timestamp' => $ebook->getParser()->getEpub()?->getOpf()?->getMetaItem('calibre:timestamp')?->getContents(),
        ]);
        $book->file()->associate($file);
        $book->library()->associate($this->library_id);
        $book->saveNoSearch();

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
}
