<?php

namespace App\Jobs;

use App\Engines\BookshelvesUtils;
use App\Jobs\Clean\CleanIndexesJob;
use App\Jobs\Cover\BookCoverJob;
use App\Jobs\Cover\SerieCoverJob;
use App\Jobs\Index\AuthorJob;
use App\Jobs\Index\BookJob;
use App\Jobs\Index\LanguageJob;
use App\Jobs\Index\PublisherJob;
use App\Jobs\Index\SerieJob;
use App\Jobs\Index\TagJob;
use App\Jobs\Library\LibraryJob;
use App\Models\Book;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AnalyzeJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    public function __construct(
        protected ?int $limit = null,
        protected bool $fresh = false,
    ) {}

    public function handle(): void
    {
        self::stepLibraries($this->limit, $this->fresh);
    }

    public static function stepLibraries(?int $limit, bool $fresh): void
    {
        Bus::batch(
            Library::inOrder()->map(fn (Library $library) => new LibraryJob($library->id, $limit, $fresh)
            )
        )->then([self::class, 'stepBooks'])->dispatch();
    }

    public static function stepBooks(Batch $batch): void
    {
        Bus::batch(
            Library::inOrder()->flatMap(function (Library $library) {
                Journal::info("Analyzing books of {$library->name}...");
                $data = BookshelvesUtils::unserialize($library->getIndexLibraryPath());
                $count = $data['count'];

                return collect($data['file_paths'])->map(
                    fn ($path, $i) => new BookJob($path, $library->id, ($i + 1)."/{$count}")
                );
            })
        )->then([self::class, 'stepIndexes'])->dispatch();
    }

    public static function stepIndexes(Batch $batch): void
    {
        Bus::batch([
            new LanguageJob,
            new PublisherJob,
            new TagJob,
            new AuthorJob,
        ])->then([self::class, 'stepSeries'])->dispatch();
    }

    public static function stepSeries(Batch $batch): void
    {
        Bus::batch([
            new SerieJob,
        ])->then([self::class, 'stepBookCovers'])->dispatch();
    }

    public static function stepBookCovers(Batch $batch): void
    {
        Bus::batch(
            Book::all()->map(fn (Book $book) => new BookCoverJob($book))
        )->then([self::class, 'stepSerieCovers'])->dispatch();
    }

    public static function stepSerieCovers(Batch $batch): void
    {
        Bus::batch(
            Serie::all()->map(fn (Serie $serie) => new SerieCoverJob($serie))
        )->then([self::class, 'stepClean'])->dispatch();
    }

    public static function stepClean(Batch $batch): void
    {
        Bus::batch([
            new CleanIndexesJob,
        ])->then([self::class, 'stepScout'])->dispatch();
    }

    public static function stepScout(Batch $batch): void
    {
        Bus::batch([
            new ScoutJob,
        ])->dispatch();
    }
}
