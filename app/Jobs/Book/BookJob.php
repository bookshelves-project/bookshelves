<?php

namespace App\Jobs\Book;

use App\Console\Commands\NotifierCommand;
use App\Engines\Book\BookEngine;
use App\Engines\Book\File\BookFileItem;
use App\Facades\Bookshelves;
use App\Models\Book;
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
        protected bool $fresh = false,
    ) {}

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

        if (! $engine) {
            Journal::warning("BookJob: {$this->number} no engine detected, with file {$file->path}");

            return;
        }

        if (! $engine->ebook()) {
            Journal::warning("BookJob: {$this->number} no ebook detected, with file {$file->path}");

            return;
        }

        $title = $engine->ebook()->getTitle() ?? $file->path;
        Journal::debug("BookJob: {$this->number} {$title} from {$this->library}");

        if (! $this->fresh && $engine->book()) {
            $engine->book()->searchable();

            if ($engine->isAudiobookAndBookExists()) {
                return;
            }

            $engine->book()->to_notify = true;
            $engine->book()->saveNoSearch();

            if (Bookshelves::displayNotifications()) {
                NotifierCommand::book($engine->book());
            }
        }

        if ($engine->book()->is_audiobook) {
            $this->fusionAudiobook($engine);
        }
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

        /** @var ?File $model */
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

    private function fusionAudiobook(BookEngine $engine): void
    {
        // find all Book with same `slug`
        $books = Book::query()
            ->where('slug', $engine->book()->slug)
            // ->where('id', '!=', $engine->book()->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // skip if no other books found
        if ($books->count() === 0) {
            Journal::info("BookJob: audiobooks {$books->count()} to fusion.");
        }

        $first = $books->first();

        Journal::debug("BookJob: audiobooks {$books->count()} to fusion.", [
            'books' => $books->pluck('id')->toArray(),
            'first' => $first ? $first->id : null,
        ]);

        // foreach ($books as $book) {
        //     $book->delete();
        // }
    }
}
