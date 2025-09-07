<?php

namespace App\Jobs;

use App\Utils;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class PipelineJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected bool $fresh = false,
        protected ?int $limit = null,
    ) {}

    public function handle(): void
    {
        $fresh = $this->fresh;
        $limit = $this->limit;

        Journal::info('Pipeline started')->toDatabase();

        $orchestrator = new \App\Jobs\JobOrchestrator;
        $orchestrator
            ->add('index.libraries', fn () => self::indexLibraries($fresh, $limit))
            ->add('index.books', fn () => self::indexBooks($fresh))
            ->add('clean.audiobooks', fn () => self::cleanAudiobooks())
            ->add('book.covers', fn () => self::bookCovers())
            ->add('index.series', fn () => self::indexSeries())
            ->add('indexes', fn () => self::indexes())
            ->add('serie.covers', fn () => self::serieCovers())
            ->add('clean', fn () => self::clean())
            ->add('scout', fn () => self::scout())
            ->dispatch();
    }

    public static function indexLibraries(bool $fresh = false, ?int $limit = null): array
    {
        return \App\Models\Library::inOrder()
            ->map(fn (\App\Models\Library $library) => new \App\Jobs\Index\LibraryJob($library, $fresh, $limit))
            ->toArray();
    }

    public static function indexBooks(bool $fresh = false): array
    {
        $paths = collect();
        foreach (\App\Models\Library::inOrder() as $library) {
            $data = Utils::unserialize($library->getIndexLibraryPath());
            $count = $data['count'];
            Journal::debug("index.books: Analyzing {$count} books of {$library->name}...");

            if ($count === 0) {
                Journal::debug("index.books: No books found in {$library->name}");

                continue;
            }

            $paths = $paths->merge(
                collect($data['file_paths'])->map(fn ($path, $i) => [
                    'path' => $path,
                    'library_id' => $library->id,
                    'position' => ($i + 1)."/{$count}",
                    'fresh' => $fresh,
                ])
            );
        }

        return $paths->map(fn ($file) => new \App\Jobs\Index\BookJob($file['path'], $file['library_id'], $file['position'], $file['fresh']))
            ->toArray();
    }

    public static function cleanAudiobooks(): array
    {
        return [new \App\Jobs\Clean\CleanAudiobookJob];
    }

    public static function bookCovers(): array
    {
        return \App\Models\Book::where('has_cover', false)
            ->get()
            ->map(fn (\App\Models\Book $book) => new \App\Jobs\Cover\BookCoverJob($book))
            ->toArray();
    }

    public static function indexes(): array
    {
        return [
            new \App\Jobs\Index\LanguageJob,
            new \App\Jobs\Index\PublisherJob,
            new \App\Jobs\Index\TagJob,
            new \App\Jobs\Index\AuthorJob,
        ];
    }

    public static function indexSeries(): array
    {
        return [new \App\Jobs\Index\SerieJob];
    }

    public static function serieCovers(): array
    {
        return \App\Models\Serie::where('has_cover', false)
            ->get()
            ->map(fn (\App\Models\Serie $serie) => new \App\Jobs\Cover\SerieCoverJob($serie))
            ->toArray();
    }

    public static function clean(): array
    {
        return [
            new \App\Jobs\Clean\CleanIndexesJob,
            new \App\Jobs\Clean\CleanNotifyJob,
            new \App\Jobs\Clean\CleanJob,
        ];
    }

    public static function scout(): array
    {
        return [new \App\Jobs\ScoutJob];
    }
}
