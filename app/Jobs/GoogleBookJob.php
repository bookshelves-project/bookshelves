<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\GoogleBook;

class GoogleBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Book $book,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("GoogleBookJob: {$this->book->title}");

        $isbn = $this->book->isbn13 ?? $this->book->isbn10;

        $googleBook = GoogleBook::make($isbn)->get();
        $item = $googleBook->getItem();

        $this->book->google_book_parsed_at = now();

        if (! $item) {
            $this->book->save();

            return;
        }

        if (! $this->book->description) {
            $this->book->description = $item->getDescription();
        }

        if (! $this->book->page_count) {
            $this->book->page_count = $item->getPageCount();
        }

        $this->book->is_maturity_rating = $item->isMaturityRating();

        if (! $this->book->isbn10) {
            $this->book->isbn10 = $item->getIsbn10();
        }

        if (! $this->book->isbn13) {
            $this->book->isbn13 = $item->getIsbn13();
        }

        if (! $this->book->publisher) {
            $publisher = $item->getPublisher();
            ray($publisher)->purple();
            $publisher = Publisher::firstOrCreate([
                'name' => $publisher,
            ]);
            $this->book->publisher()->associate($publisher);
        }

        $tags = $item->getCategories();
        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
            $this->book->tags()->syncWithoutDetaching($tag);
        }

        if (! $this->book->language) {
            $language = $item->getLanguage();
            $language = Language::firstOrCreate([
                'slug' => $language,
            ]);
            $this->book->language()->associate($language);
        }

        $this->book->save();
    }
}
