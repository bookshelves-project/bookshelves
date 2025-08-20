<?php

namespace App\Jobs\Book;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\BookConverter;
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
 * Create a new book.
 */
class BooksIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  File[]  $files
     */
    public function __construct(
        protected array $files,
        protected Library $library,
        protected bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info("BooksIndexJob: Indexing library {$this->library->name}...");

        foreach ($this->files as $key => $file) {
            // Journal::info("BooksIndexJob: Indexing book: {$file->basename}...");
            /** @var Ebook $ebook */
            $ebook = BookshelvesUtils::unserialize($file->getBookIndexPath());
            BookConverter::make($ebook, $file);
        }

        Journal::info('BooksIndexJob: Indexing library done!');
    }
}
