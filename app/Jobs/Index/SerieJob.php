<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\SerieModule;
use App\Engines\Converter\SerieConverter;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class SerieJob implements ShouldQueue
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
        Journal::info('SerieJob: handle series...');

        $this->createSeries();
        $this->attachSeries();

        Serie::all()->load(['tags'])->each(function (Serie $serie) {
            SerieConverter::make($serie, true);
        });
    }

    private function createSeries(): void
    {
        $items = collect();
        Book::where('has_series', true)->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexSeriePath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            $items->add($data);
        });

        $items = $items->unique(fn ($serie) => $serie['slug'].$serie['library_id'])->values();
        $items->each(function ($serie) {
            SerieModule::make($serie['title'], $serie['slug'], $serie['library_id']);
        });
    }

    private function attachSeries(): void
    {
        Book::where('has_series', true)->each(function (Book $book) {
            $index_path = $book->getIndexSeriePath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = BookshelvesUtils::unserialize($index_path);
            $serie = Serie::where('slug', $data['slug'])
                ->where('library_id', $data['library_id'])
                ->first();

            if ($serie) {
                SerieModule::associate($serie, $book);
            }
        });
    }
}
