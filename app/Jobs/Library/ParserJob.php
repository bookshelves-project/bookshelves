<?php

namespace App\Jobs\Library;

use App\Engines\Book\File\BookFileScanner;
use App\Jobs\Book\BooksDispatchJob;
use App\Jobs\Clean\DuplicatesJob;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class ParserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Library $library,
        protected ?int $limit = null,
        protected bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info("LibraryParserJob: {$this->library->name} parsing files...");

        $parser = BookFileScanner::make($this->library, $this->limit);

        if (! $parser) {
            Journal::warning("LibraryParserJob: {$this->library->name} no files detected");

            return;
        }

        $msg = "LibraryParserJob: {$this->library->name} files detected: {$parser->getCount()}";
        if ($this->limit) {
            $msg .= " (limited to {$this->limit})";
        }
        Journal::info($msg);

        BooksDispatchJob::dispatch($this->library, $parser->getPaths(), $this->fresh);
        DuplicatesJob::dispatch();
    }
}
