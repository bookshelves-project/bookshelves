<?php

namespace App\Jobs;

use App\Console\Commands\NotifierCommand;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifierJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Library $library,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->library->loadMissing('books');

        foreach ($this->library->books as $book) {
            if ($book->is_notified) {
                continue;
            }

            if (! $book->to_notify) {
                continue;
            }

            NotifierCommand::make($book);
        }
    }
}
