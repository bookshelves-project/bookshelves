<?php

namespace App\Jobs;

use App\Engines\BookshelvesUtils;
use App\Jobs\Cover\BookCoverJob;
use App\Jobs\Cover\SerieCoverJob;
use App\Jobs\Index\IndexAuthorJob;
use App\Jobs\Index\IndexBookJob;
use App\Jobs\Index\IndexLanguageJob;
use App\Jobs\Index\IndexPublisherJob;
use App\Jobs\Index\IndexSerieJob;
use App\Jobs\Index\IndexTagJob;
use App\Jobs\Library\LibraryJob;
use App\Models\Book;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;

class AnalyzeJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

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
                ->map(fn (Library $library) => new LibraryJob($library->id, $this->limit, $this->fresh))
        )->then(function (Batch $batch) {
            Bus::batch(
                Library::inOrder()->flatMap(function (Library $library) {
                    $data = BookshelvesUtils::unserialize($library->getIndexLibraryPath());
                    $count = $data['count'];

                    return collect($data['file_paths'])->map(
                        fn ($path, $i) => new IndexBookJob($path, $library->id, ($i + 1)."/{$count}")
                    );
                })
            )->then(function (Batch $batch) {
                Bus::batch([
                    new IndexLanguageJob,
                    new IndexPublisherJob,
                    new IndexTagJob,
                    new IndexAuthorJob,
                ])->then(function (Batch $batch) {
                    Bus::batch(
                        new IndexSerieJob,
                    )->then(function (Batch $batch) {
                        Bus::batch(
                            Book::all()->map(fn (Book $book) => new BookCoverJob($book))
                        )->then(function (Batch $batch) {
                            Bus::batch(
                                Serie::all()->map(fn (Serie $serie) => new SerieCoverJob($serie))
                            )->dispatch();
                        })->dispatch();
                    })->dispatch();
                })->dispatch();
            })->dispatch();
        })->dispatch();
    }
}
