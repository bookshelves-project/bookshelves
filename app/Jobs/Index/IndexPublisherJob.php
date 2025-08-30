<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\PublisherModule;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class IndexPublisherJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('IndexPublisherJob: handle publishers...');

        $this->createPublishers();
        $this->attachPublishers();
    }

    private function createPublishers(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexPublisherPath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            $items->add($data);
        });

        $items = $items->unique(fn ($publisher) => $publisher)->values();
        $items->each(function ($publisher) {
            PublisherModule::make($publisher);
        });
    }

    private function attachPublishers(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexPublisherPath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            $publisher = Publisher::where('name', $data)->first();

            if ($publisher) {
                $book->publisher()->associate($publisher);
                $book->saveNoSearch();
            }
        });
    }
}
