<?php

namespace App\Jobs;

use App\Engines\Book\Converter\SerieConverter;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class SerieJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Serie $serie,
        public bool $fresh = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->serie->loadMissing('library');

        Journal::info("SerieJob: {$this->serie->title} from {$this->serie->library->name}...");
        SerieConverter::make($this->serie, $this->fresh);
    }
}
