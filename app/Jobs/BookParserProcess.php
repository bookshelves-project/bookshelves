<?php

namespace App\Jobs;

use App\Engines\Book\BookFileReader;
use App\Engines\BookEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BookParserProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected BookFileReader $file,
        protected bool $verbose = false,
        protected bool $default = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        BookEngine::make($this->file, $this->verbose, $this->default);
    }
}
