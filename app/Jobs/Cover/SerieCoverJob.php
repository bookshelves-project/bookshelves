<?php

namespace App\Jobs\Cover;

use App\Engines\Converter\SerieConverter;
use App\Facades\Bookshelves;
use App\Models\Serie;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class SerieCoverJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Serie $serie,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (Bookshelves::verbose()) {
            Journal::debug("SerieCoverJob: {$this->serie->title}...");
        }

        SerieConverter::makeCover($this->serie);
    }
}
