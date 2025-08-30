<?php

namespace App\Jobs;

use App\Engines\BookshelvesUtils;
use App\Jobs\Book\BookIndexJob;
use App\Jobs\Library\LibraryJob;
use App\Models\Library;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;

class AnalyzeJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected ?int $limit = null,
        protected bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Bus::batch(
            Library::inOrder()
                ->map(
                    fn (Library $library) => new LibraryJob($library->id, $this->limit, $this->fresh)
                )
        )->then(function (Batch $batch) {
            Library::inOrder()->each(function (Library $library) {
                $data = BookshelvesUtils::unserialize($library->getLibraryIndexPath());
                $count = $data['count'];
                foreach ($data['file_paths'] as $i => $path) {
                    $current = $i + 1;
                    BookIndexJob::dispatch($path, $library->id, "{$current}/{$count}");
                }
            });
        })->then(function (Batch $batch) {
            // Handle the successful completion of the batch
        })->dispatch();
    }
}
