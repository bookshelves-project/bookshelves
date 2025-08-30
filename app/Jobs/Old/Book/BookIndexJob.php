<?php

namespace App\Jobs\Book;

use App\Engines\BookshelvesUtils;
use App\Engines\Library\FileItem;
use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\File;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Create an index for a book from `FileItem`.
 */
class BookIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private FileItem $file_item,
        private string|int $library_id,
        private ?string $number = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (Bookshelves::verbose()) {
            Journal::debug("BookIndexJob: {$this->number} `{$this->file_item->getBasename()}`...");
        }

        $file = $this->convertFileItem($this->file_item);
        $this->parseEbook($file);

        /** @var Ebook $ebook */
        $ebook = BookshelvesUtils::unserialize($file->getFileIndexPath());

        // $i = 0;
        // $count = count($file_items);
        // $files = [];

        // foreach ($file_items as $file_item) {
        //     $i++;
        //     $file = $this->convertFileItem($file_item);
        //     $files[] = $file;
        //     $this->handleBookJob("{$i}/{$count}", $file);
        // }

        // foreach ($files as $i => $file) {

        //     if (Bookshelves::verbose()) {
        //         Journal::debug("LibraryScanJob: {$i}/{$count} {$file->basename} from {$this->library->name}");
        //     }
        //     BookConverter::make($ebook, $file);
        // }
    }

    private function parseEbook(File $file): void
    {
        try {
            $ebook = Ebook::read($file->path);
            $ebook->getPagesCount();
        } catch (\Throwable $th) {
            Journal::error("XML error on {$file->path}", [$th->getMessage()]);

            return;
        }

        $index_path = $file->getFileIndexPath();
        BookshelvesUtils::serialize($index_path, $ebook);

        if (! $ebook) {
            Journal::warning("BookIndexJob: {$this->number} no ebook detected at {$file->path}", [
                'ebook' => $ebook,
            ]);

            return;
        }
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
}
