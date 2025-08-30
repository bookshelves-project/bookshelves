<?php

namespace App\Jobs\Book;

use App\Engines\Library\FileItem;
use App\Models\Book;
use App\Models\File;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;
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
        /** @var Book $book */
        $book = Book::create([
            'title' => $file->basename,
            'slug' => Str::slug($file->basename),
        ]);
        $book->file()->associate($file);
        $book->library()->associate($this->library_id);
        $book->saveNoSearch();
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
