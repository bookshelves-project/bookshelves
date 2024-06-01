<?php

namespace App\Jobs;

use App\Console\Commands\Bookshelves\BooksCommand;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\LaravelNotifier\Facades\Journal;

class ParserWrapperJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected bool $fresh = false,
        protected ?int $limit = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $libraries = Library::inOrder()->map(fn (Library $library) => $library->name)->toArray();
        $librariesStr = implode(', ', $libraries);
        Journal::info("ParserJob: start parsing libraries: {$librariesStr}");

        foreach (Library::inOrder() as $library) {
            ParserJob::dispatch($library, $this->limit);
        }

        Artisan::call(BooksCommand::class, ['--fresh' => $this->fresh]);
    }
}
