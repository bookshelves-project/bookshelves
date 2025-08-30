<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\LanguageModule;
use App\Models\Book;
use App\Models\Language;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class IndexLanguageJob implements ShouldQueue
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
        Journal::info('IndexLanguageJob: handle languages...');

        $this->createLanguages();
        $this->attachLanguages();
    }

    private function createLanguages(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexLanguagePath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            $items->add($data);
        });

        $items = $items->unique(fn ($language) => $language)->values();

        $items->each(function ($language) {
            LanguageModule::make($language);
        });
    }

    private function attachLanguages(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexLanguagePath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);

            $language = Language::where('slug', $data)->first();
            $book->language()->associate($language);
            $book->saveNoSearch();
        });
    }
}
