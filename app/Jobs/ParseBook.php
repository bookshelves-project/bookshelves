<?php

namespace App\Jobs;

use App\Engines\Book\BookFileReader;
use App\Engines\Book\ConverterEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Ebook\Ebook;

class ParseBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Ebook $ebook,
        protected BookFileReader $file,
        protected bool $default = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $converter = ConverterEngine::make($this->ebook, $this->file, $this->default);
    }
}
