<?php

namespace App\Jobs\Library;

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
        Journal::info("LibraryParserJob: {$this->library->name} parsing files...");

        $parser = BookFileScanner::make($this->library, $this->limit);
        $jsonPath = $this->library->getJsonPath();

        if (file_exists($jsonPath)) {
            unlink($jsonPath);
        }

        if (! $parser) {
            Journal::warning("LibraryParserJob: {$this->library->name} no files detected");
            file_put_contents($jsonPath, '[]');

            return;
        }

        Converter::saveAsJson($parser->getPaths(), $jsonPath);

        $msg = "LibraryParserJob: {$this->library->name} files detected: {$parser->getCount()}";
        if ($this->limit) {
            $msg .= " (limited to {$this->limit})";
        }
        Journal::info($msg);
    }
}
