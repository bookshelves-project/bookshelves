<?php

namespace App\Jobs\Index;

use App\Engines\Converter\Modules\TagModule;
use App\Models\Book;
use App\Models\Tag;
use App\Utils;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class TagJob implements ShouldQueue
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
        Journal::info('TagJob: handle tags...');

        $this->createTags();
        $this->attachTags();
    }

    private function createTags(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexTagPath();
            if (! file_exists($index_path)) {
                return;
            }
            $tags = Utils::unserialize($index_path);
            $items->push(...$tags);
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
            $tags = Utils::unserialize($index_path);

            $items = [];
            foreach ($tags as $tag) {
                $items[] = Tag::where('slug', $tag)->first();
            }

            $items = array_values(array_filter($items));
            $book->tags()->sync($items);
        });
    }
}
