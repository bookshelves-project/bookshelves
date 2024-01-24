<?php

namespace App\Jobs;

use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SerieWrapperJob implements ShouldQueue
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
        if ($this->fresh) {
            $series = Serie::all();
        } else {
            $series = Serie::query()
                ->where('wikipedia_parsed_at', null)
                ->get();
        }

        foreach ($series as $serie) {
            SerieJob::dispatch($serie, $this->fresh);
        }
    }
}
