<?php

namespace App\Jobs\Clean;

use App\Console\Commands\NotifierCommand;
use App\Models\Book;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class CleanNotifyJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('CleanNotifyJob: cleaning notifications...');

        Book::query()
            ->where('to_notify', true)
            ->with(['authors', 'library', 'serie'])
            ->get()
            ->each(function (Book $book) {
                NotifierCommand::book($book);
            });
    }
}
