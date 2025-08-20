<?php

namespace App\Jobs\Author;

use App\Engines\Converter\AuthorConverter;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AuthorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Author $author,
        public bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $msg = 'Disabled cause of Wikipedia API restrictions';
        Journal::debug($msg);

        // if ($this->author->api_parsed_at !== null && ! $this->fresh) {
        //     return;
        // }

        // Journal::info("AuthorJob: {$this->author->name}");
        // AuthorConverter::make($this->author, $this->fresh);
    }
}
