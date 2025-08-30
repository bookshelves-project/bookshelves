<?php

namespace App\Jobs;

use App\Engines\BookshelvesUtils;
use App\Jobs\Author\AuthorIndexJob;
use App\Jobs\Book\BookCoverJob;
use App\Jobs\Book\BookIndexJob;
use App\Jobs\Library\LibraryJob;
use App\Jobs\Serie\SerieIndexJob;
use App\Models\Book;
use App\Models\Library;
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
                        fn ($path, $i) => new BookIndexJob($path, $library->id, ($i + 1)."/{$count}")
                    );
                })
            )->then(function (Batch $batch) {
                Bus::batch([
                    new AuthorIndexJob,
                    new SerieIndexJob,
                ])->then(function (Batch $batch) {
                    Bus::batch(
                        Book::all()->map(fn (Book $book) => new BookCoverJob($book))
                    )->dispatch();
                })->dispatch();
            })->dispatch();
        })->dispatch();
    }
}
