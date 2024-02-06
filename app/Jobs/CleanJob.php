<?php

namespace App\Jobs;

use App\Enums\BookTypeEnum;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Notifier\Facades\Journal;
use Kiwilan\Steward\Services\DirectoryService;

class CleanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $enums = BookTypeEnum::cases();

        foreach ($enums as $enum) {
            $this->deleteOrphanBooks($enum);
        }

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
    }

    private function deleteOrphanBooks(BookTypeEnum $enum)
    {
        $path = $enum->jsonPath();
        $contents = file_get_contents($path);
        $files = (array) json_decode($contents, true);

        $books = Book::query()
            ->where('type', $enum->value)
            ->get()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();
        $files = array_map(fn ($file) => $file['path'], $files);

        $orphans = array_diff($books, $files);
        $books = Book::query()
            ->whereIn('physical_path', $orphans)
            ->get();

        Journal::info("Clean: {$enum->value} {$books->count()}");

        foreach ($books as $book) {
            $book->delete();
        }
    }
}
