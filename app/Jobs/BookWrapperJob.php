<?php

namespace App\Jobs;

use App\Engines\Book\BookFileScanner;
use App\Enums\BookTypeEnum;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookWrapperJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
        public ?int $limit = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $enums = BookTypeEnum::cases();

        foreach ($enums as $enum) {
            $this->parseFiles($enum);
        }
    }

    private function parseFiles(BookTypeEnum $enum)
    {
        $parser = BookFileScanner::make($enum, limit: $this->limit);

        if (! $parser) {
            Log::warning("BookWrapperJob: {$enum->value} no files detected");

            return;
        }

        $files = $parser->items();
        $count = count($files);
        Log::info("BookWrapperJob: {$enum->value} files detected: {$count}");

        $current_books = Book::all()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();

        $i = 0;
        foreach ($files as $file) {
            $i++;
            if (! $this->fresh && in_array($file->path(), $current_books, true)) {
                continue;
            }

            BookJob::dispatch($file, "{$i}/{$count}");
        }
    }
}
