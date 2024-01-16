<?php

namespace App\Jobs;

use App\Engines\Book\BookFileItem;
use App\Engines\BookEngine;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookParserProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected BookFileItem $file,
        protected string $number,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $engine = BookEngine::make($this->file);
        $title = $engine->ebook()->getTitle();
        if (! $title) {
            $title = $this->file->path();
        }
        Log::info("BookParserProcess: {$this->number} {$title}");
    }

    private function log(string $message, bool $success = false): void
    {
        $path = public_path('storage/data/logs/exceptions-parser.json');

        if (! file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        $json = json_decode(file_get_contents($path), true);
        $content = [
            'path' => $this->file->path(),
            'message' => $message,
            'status' => $success ? 'success' : 'failed',
        ];
        $json[] = $content;
        file_put_contents($path, json_encode($json));

        if ($success) {
            Log::info('BookParserProcess', $content);
        } else {
            Log::error('BookParserProcess', $content);
        }
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->log($exception->getMessage());
    }
}
