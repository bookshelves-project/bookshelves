<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kiwilan\HttpPool\Utils\PrintConsole;
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
        Log::info('GoogleBookProcess');

        $books = Book::all();
        $service = GoogleBookService::make($books)
            ->setIsbnFields(['isbn13', 'isbn10'])
            ->setDebug($this->verbose);

        $console = PrintConsole::make();
        $count = $service->getCount();
        $booksCount = Book::query()->count();
        $isbn_types = implode('/', ['isbn13', 'isbn10']);
        $console->print("Need to have {$isbn_types}, on {$booksCount} entities, {$count} entities can be scanned.");

        if ($count === 0) {
            $console->print('No entities to scan.', 'red');

            return;
        }

        $start = microtime(true);
        $service = $service->execute();

        // $bar = $this->output->createProgressBar(count($service->items()));

        foreach ($service->getItems() as $id => $item) {
            Log::info("GoogleBookProcess: {$id}");
            $model = Book::query()->find($id);

            if ($model instanceof GoogleBookable) {
                $model->googleBookConvert($item);
            }
        }

        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $console->print("Time in seconds: {$time_elapsed_secs}");
    }
}
