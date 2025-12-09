<?php

namespace App\Jobs\Index;

use App\Jobs\Relation;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class RelationsJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('RelationsJob: handle relations...');

        new Relation\LanguageJob;
        new Relation\PublisherJob;
        new Relation\TagJob;
        new Relation\AuthorJob;
        new Relation\SerieJob;
    }
}
