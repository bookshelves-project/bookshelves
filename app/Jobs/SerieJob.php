<?php

namespace App\Jobs;

use App\Engines\Book\Converter\SerieConverter;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Notifier\Facades\Journal;

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
        Journal::info("SerieJob: {$this->serie->title}");
        SerieConverter::make($this->serie, $this->fresh);
    }
}
