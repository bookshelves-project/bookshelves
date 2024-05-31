<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Services\DirectoryService;

class CleanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $libraries = Library::all();

        foreach ($libraries as $library) {
            $this->deleteOrphanBooks($library);
        }

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
    }

    private function deleteOrphanBooks(Library $library)
    {
        $contents = file_get_contents($library->getJsonPath());
        $physical_files = (array) json_decode($contents, true);

        $files = File::query()
            ->where('library_id', $library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        if (empty($files)) {
            Journal::warning("Clean: {$library->name} no books detected");

            return;
        }

        $physical_files = array_map(fn ($file) => $file['path'], $physical_files);

        $orphans = array_diff($files, $physical_files);
        $files = File::query()
            ->whereIn('path', $orphans)
            ->get();

        Journal::info("Clean: {$library->name} {$files->count()}");

        foreach ($files as $file) {
            $file->delete();
        }
    }
}
