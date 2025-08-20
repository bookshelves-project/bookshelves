<?php

namespace App\Jobs\Serie;

use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SeriesDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $series = $this->getSeries($this->fresh);
        if ($series->isEmpty()) {
            return;
        }

        foreach ($series as $serie) {
            SerieJob::dispatch($serie, $this->fresh);
        }
    }

    /**
     * @return Collection<int, Serie>
     */
    private function getSeries(bool $fresh): Collection
    {
        if ($fresh) {
            return Serie::all();
        }

        return Serie::query()
            ->where('parsed_at', null)
            ->get();
    }
}
