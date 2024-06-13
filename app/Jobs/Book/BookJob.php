<?php

namespace App\Jobs\Book;

use App\Engines\Book\BookEngine;
use App\Engines\Book\File\BookFileItem;
use App\Facades\Bookshelves;
use App\Models\File;
use Error;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected bool $isExist = false;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected BookFileItem $bookFile,
        protected string $number,
        protected string $library,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = $this->getFile($this->bookFile);

        if ($this->isExist) {
            return;
        }

        $engine = BookEngine::make($file);
        if (! $engine->ebook()) {
            Journal::warning("BookJob: {$this->number} no ebook detected");

            return;
        }

        $title = $engine->ebook()->getTitle() ?? $file->path;
        Journal::debug("BookJob: {$this->number} {$title} from {$this->library}");
    }

    private function getFile(BookFileItem $bookFile): File
    {
        $data = [
            'path' => $bookFile->path(),
            'basename' => $bookFile->basename(),
            'extension' => $bookFile->extension(),
            'mime_type' => $bookFile->mimeType(),
            'size' => $bookFile->size(),
            'date_added' => $bookFile->dateAdded(),
            'library_id' => $bookFile->libraryId(),
        ];

        $model = File::query()
            ->where('path', $bookFile->path())
            ->where('library_id', $bookFile->libraryId())
            ->first();

        if ($model) {
            $model->update($data);
            $this->isExist = true;
        } else {
            $model = File::query()->create($data);
        }

        return $model;
    }

    private function log(string $message): void
    {
        $path = Bookshelves::exceptionParserLog();
        $json = json_decode(file_get_contents($path), true);
        $content = [
            'path' => $this->bookFile->path(),
            'message' => $message,
            'status' => 'failed',
        ];
        $json[] = $content;
        file_put_contents($path, json_encode($json));

        Journal::error('BookJob', $content);
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed(Exception|Error $exception)
    {
        $this->log($exception->getMessage());
    }
}
