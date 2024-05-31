<?php

namespace App\Jobs;

use App\Engines\Book\File\BookFileScanner;
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
        protected Library $library,
        protected ?int $limit = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info("ParserJob: {$this->library->name} parsing files...");

        $parser = BookFileScanner::make($this->library, $this->limit);
        $jsonPath = $this->library->getJsonPath();

        if (file_exists($jsonPath)) {
            unlink($jsonPath);
        }

        if (! $parser) {
            Journal::warning("ParserJob: {$this->library->name} no files detected");
            file_put_contents($jsonPath, '[]');

            return;
        }

        $files = $parser->items();
        $count = count($files);

        $items = [];
        foreach ($files as $file) {
            $items[] = $file->toArray();
        }

        Converter::saveAsJson($items, $jsonPath);

        $msg = "ParserJob: {$this->library->name} files detected: {$count}";
        if ($this->limit) {
            $msg .= " (limited to {$this->limit})";
        }
        Journal::info($msg);
    }
}
