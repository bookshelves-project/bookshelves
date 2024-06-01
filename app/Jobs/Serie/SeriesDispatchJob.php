<?php

namespace App\Jobs\Serie;

use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class SeriesDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('AuthorDispatchJob: dispatching authors...', [
            'fresh' => $this->fresh,
        ]);

        $authors = $this->getSeries($this->fresh);
        if ($authors->isEmpty()) {
            Journal::error('AuthorDispatchJob: no authors found');

            return;
        }

        foreach ($authors as $author) {
            SerieJob::dispatch($author, $this->fresh);
        }
    }

    private function getSeries(bool $fresh): mixed
    {
        if ($fresh) {
            return Serie::all();
        }

        return Serie::query()
            ->where('parsed_at', null)
            ->get();
    }
}
