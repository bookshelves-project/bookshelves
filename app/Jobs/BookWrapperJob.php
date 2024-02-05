<?php

namespace App\Jobs;

use App\Engines\Book\BookFileItem;
use App\Enums\BookTypeEnum;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $current_books = Book::all()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();

        foreach ($enums as $enum) {
            $this->parseFiles($enum, $current_books);
        }

        ExtrasJob::dispatch();
    }

    /**
     * @param  string[]  $current_books
     */
    private function parseFiles(BookTypeEnum $enum, array $current_books)
    {
        $path = $enum->jsonPath();
        $contents = file_get_contents($path);
        $files = (array) json_decode($contents, true);
        if ($this->limit && count($files) > $this->limit) {
            $files = array_slice($files, 0, $this->limit);
        }
        $count = count($files);

        $i = 0;
        foreach ($files as $file) {
            $i++;

            $file = BookFileItem::fromArray($file);
            if ($this->fresh) {
                BookJob::dispatch($file, "{$i}/{$count}");
            } else {
                if (in_array($file->path(), $current_books, true)) {
                    continue;
                }

                BookJob::dispatch($file, "{$i}/{$count}");
            }
        }
    }
}
