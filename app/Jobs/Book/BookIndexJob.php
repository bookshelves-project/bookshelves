<?php

namespace App\Jobs\Book;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\IdentifierModule;
use App\Engines\Library\FileItem;
use App\Models\Book;
use App\Models\File;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookIndexJob implements ShouldQueue
{
    use Batchable, Queueable;

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
        Journal::info("Book index {$this->position} started {$this->file_path}");

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_item = FileItem::make($this->file_path, $this->library_id, $finfo);
        finfo_close($finfo);

        $file = $this->convertFileItem($file_item);
        $ebook = Ebook::read($this->file_path);

        if (! $ebook->getTitle() || ! $ebook->getMetaTitle()) {
            Journal::error('BookIndexJob: No title or meta title found', [
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
            'description' => $ebook->getDescriptionAdvanced()->toHtml(2000),
            'rights' => $ebook->getCopyright(255),
            'volume' => $this->parseVolume($ebook->getVolume()),
            'page_count' => $ebook->getPagesCount(),
            'isbn10' => $identifiers->get('isbn10') ?? null,
            'isbn13' => $identifiers->get('isbn13') ?? null,
            'identifiers' => $identifiers->toArray(),
            'added_at' => $ebook->getCreatedAt(),
            'calibre_added_at' => $ebook->getParser()->getEpub()?->getOpf()?->getMetaItem('calibre:timestamp'),
        ]);
        $book->file()->associate($file);
        $book->library()->associate($this->library_id);
        $book->saveNoSearch();

        BookshelvesUtils::serialize($book->getBookIndexPath(), $ebook);
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
