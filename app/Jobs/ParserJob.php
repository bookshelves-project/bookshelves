<?php

namespace App\Jobs;

use App\Engines\Book\BookFileScanner;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\Converter;

class ParserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected ?int $limit = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $libraries = Library::all();

        foreach ($libraries as $library) {
            $this->parseFiles($library);
        }
    }

    private function parseFiles(Library $library)
    {
        $parser = BookFileScanner::make($library, $this->limit);
        $jsonPath = $library->getJsonPath();

        if (file_exists($jsonPath)) {
            unlink($jsonPath);
        }

        if (! $parser) {
            Journal::warning("ParserJob: {$library->name} no files detected");
            file_put_contents($jsonPath, '[]');

            return;
        }

        $files = $parser->items();
        $count = count($files);
        Journal::info("ParserJob: {$library->name} files detected: {$count}", [
            'method' => __METHOD__,
        ]);

        $items = [];
        foreach ($files as $file) {
            $items[] = $file->toArray();
        }

        Converter::saveAsJson($items, $jsonPath);
    }
}
