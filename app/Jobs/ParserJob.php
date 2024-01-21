<?php

namespace App\Jobs;

use App\Engines\Book\BookFileScanner;
use App\Enums\BookTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kiwilan\Steward\Utils\Converter;

class ParserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('ParserJob: start');
        $enums = BookTypeEnum::cases();

        foreach ($enums as $enum) {
            $this->parseFiles($enum);
        }

        Log::info('ParserJob: done');
    }

    private function parseFiles(BookTypeEnum $enum)
    {
        $parser = BookFileScanner::make($enum);
        $jsonPath = $enum->jsonPath();

        if (file_exists($jsonPath)) {
            unlink($jsonPath);
        }

        if (! $parser) {
            Log::warning("ParserJob: {$enum->value} no files detected");
            file_put_contents($jsonPath, '[]');

            return;
        }

        $files = $parser->items();
        $count = count($files);
        Log::info("ParserJob: {$enum->value} files detected: {$count}");

        $items = [];
        foreach ($files as $file) {
            $items[] = $file->toArray();
        }

        Converter::saveAsJson($items, $jsonPath);
    }
}
