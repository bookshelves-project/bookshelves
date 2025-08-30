<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\SerieModule;
use App\Engines\Converter\Modules\TagModule;
use App\Models\Book;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class IndexTagJob implements ShouldQueue
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
        Journal::info('IndexTagJob: handle tags...');

        $this->createTags();
        // $this->attachTags();

        // Tag::all()->load(['books'])->each(function (Tag $tag) {
        //     TagConverter::make($tag, true);
        // });
    }

    private function createTags(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexTagPath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            $items->push(...$data);
        });

        $items = $items->unique(fn ($tag) => $tag)->values();
        $items->each(function ($tag) {
            TagModule::make($tag);
        });
    }

    private function attachTags(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexTagPath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            // $tag = Tag::where('slug', $data['slug'])
            //     ->where('library_id', $data['library_id'])
            //     ->first();

            // if ($tag) {
            //     SerieModule::associate($tag, $book);
            // }
        });
    }
}
