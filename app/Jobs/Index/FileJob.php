<?php

namespace App\Jobs\Index;

use App\Engines\Library\FileItem;
use App\Facades\Bookshelves;
use App\Models\File;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Throwable;

class FileJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $file_path,
        public string|int $library_id,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_item = FileItem::make($this->file_path, $this->library_id, $finfo);
        unset($finfo);

        if (Bookshelves::verbose()) {
            Journal::debug("FileJob: {$file_item->getBasename()}...");
        }

        $file = $this->convertFileItem($file_item);
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

    public function failed(?Throwable $exception): void
    {
        Journal::error("FileJob failed for file {$this->file_path} in library {$this->library_id}.", [
            'exception' => $exception?->getMessage(),
            'file_path' => $this->file_path,
            'library_id' => $this->library_id,
        ])
            ->toDatabase()
            ->toNotifier('discord');
    }
}
