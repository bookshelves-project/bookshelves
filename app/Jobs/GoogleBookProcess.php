<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Steward\Services\GoogleBook\GoogleBookable;
use Kiwilan\Steward\Services\GoogleBookService;

class GoogleBookProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected bool $verbose = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $books = Book::all();
        $service = GoogleBookService::make($books)
            ->setIsbnFields(['isbn13', 'isbn10'])
            ->setDebug($this->verbose)
        ;

        $count = $service->getCount();
        $isbn_types = implode('/', ['isbn13', 'isbn10']);
        // $this->comment("Need to have {$isbn_types}, on {$className::count()} entities, {$count} entities can be scanned.");

        // if (0 === $count) {
        //     $this->warn('No entities to scan.');

        //     return $count;
        // }

        $start = microtime(true); // register time
        $service = $service->execute();

        // $bar = $this->output->createProgressBar(count($service->items()));

        foreach ($service->getItems() as $id => $item) {
            $model = Book::find($id);

            if ($model instanceof GoogleBookable) {
                $model->googleBookConvert($item);
            }
        }

        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        // $this->info("Time in seconds: {$time_elapsed_secs}"); // display time
    }
}
