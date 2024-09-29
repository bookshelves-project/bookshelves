<?php

namespace App\Jobs\Clean;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Steward\Services\DirectoryService;

class CleanAllJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DirectoryService::make()->clearDirectory(storage_path('app/audiobooks'));
        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
        DirectoryService::make()->clearDirectory(storage_path('app/data'));
        DirectoryService::make()->clearDirectory(storage_path('app/debug'));
        DirectoryService::make()->clearDirectory(storage_path('app/library'));
        DirectoryService::make()->clearDirectory(storage_path('app/model-backup'));
        DirectoryService::make()->clearDirectory(storage_path('app/public/covers'));
        $this->deleteFile(storage_path('app/exceptions-parser.json'));
    }

    private function deleteFile(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
