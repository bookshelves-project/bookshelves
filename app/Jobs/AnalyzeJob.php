<?php

namespace App\Jobs;

use App\Jobs\Clean\CleanAudiobookJob;
use App\Jobs\Clean\CleanIndexesJob;
use App\Jobs\Clean\CleanJob;
use App\Jobs\Clean\CleanNotifyJob;
use App\Jobs\Cover\BookCoverJob;
use App\Jobs\Cover\SerieCoverJob;
use App\Jobs\Index\AuthorJob;
use App\Jobs\Index\BookJob;
use App\Jobs\Index\LanguageJob;
use App\Jobs\Index\LibraryJob;
use App\Jobs\Index\PublisherJob;
use App\Jobs\Index\SerieJob;
use App\Jobs\Index\TagJob;
use App\Models\Book;
use App\Models\Library;
use App\Models\Serie;
use App\Utils;
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
            Library::inOrder()->map(function (Library $library) use ($limit, $fresh) {
                return new LibraryJob($library->id, $limit, $fresh);
            })
        )
            ->then(function (Batch $batch) use ($fresh) {
                self::stepBooks($batch, $fresh);
            })
            ->dispatch();
    }

    public static function stepBooks(Batch $batch, bool $fresh): void
    {
        $jobs = Library::inOrder()->flatMap(function (Library $library) use ($fresh) {
            $data = Utils::unserialize($library->getIndexLibraryPath());
            $count = $data['count'];

            Journal::info("Analyzing {$count} books of {$library->name}...");

            if ($count === 0) {
                return collect();
            }

            return collect($data['file_paths'])->map(
                fn ($path, $i) => new BookJob($path, $library->id, ($i + 1)."/{$count}", $fresh)
            );
        });

        if ($jobs->isEmpty()) {
            self::stepAudiobook($batch);

            return;
        }

        Bus::batch($jobs)
            ->then([self::class, 'stepAudiobook'])
            ->dispatch();
    }

    public static function stepAudiobook(Batch $batch): void
    {
        Bus::batch([
            new CleanAudiobookJob,
        ])
            ->then([self::class, 'stepIndexes'])
            ->dispatch();
    }

    public static function stepIndexes(Batch $batch): void
    {
        Bus::batch([
            new LanguageJob,
            new PublisherJob,
            new TagJob,
            new AuthorJob,
        ])
            ->then([self::class, 'stepSeries'])
            ->dispatch();
    }

    public static function stepSeries(Batch $batch): void
    {
        Bus::batch([
            new SerieJob,
        ])
            ->then([self::class, 'stepBookCovers'])
            ->dispatch();
    }

    public static function stepBookCovers(Batch $batch): void
    {
        $jobs = Book::where('has_cover', false)
            ->get()
            ->map(fn (Book $book) => new BookCoverJob($book));

        if ($jobs->isEmpty()) {
            self::stepSerieCovers($batch);

            return;
        }

        Bus::batch($jobs)
            ->finally([self::class, 'stepSerieCovers'])
            ->dispatch();
    }

    public static function stepSerieCovers(Batch $batch): void
    {
        $jobs = Serie::where('has_cover', false)
            ->get()
            ->map(fn (Serie $serie) => new SerieCoverJob($serie));

        if ($jobs->isEmpty()) {
            self::stepClean($batch);

            return;
        }

        Bus::batch($jobs)
            ->finally([self::class, 'stepClean'])
            ->dispatch();
    }

    public static function stepClean(Batch $batch): void
    {
        Bus::batch([
            new CleanIndexesJob,
            new CleanNotifyJob,
            new CleanJob,
        ])
            ->then([self::class, 'stepScout'])
            ->dispatch();
    }

    public static function stepScout(Batch $batch): void
    {
        Bus::batch([
            new ScoutJob,
        ])
            ->dispatch();
    }
}
