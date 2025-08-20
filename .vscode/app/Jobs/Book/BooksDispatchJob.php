<?php

namespace App\Jobs\Book;

use App\Engines\Book\File\BookFileItem;
use App\Jobs\Clean\CleanDispatchJob;
use App\Jobs\Clean\ScoutJob;
use App\Models\File;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BooksDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  string[]  $paths
     */
    public function __construct(
        public Library $library,
        public array $paths = [],
        public bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::debug('BooksDispatchJob: create BookJob for each item...');

        if (empty($this->paths)) {
            Journal::error("BooksDispatchJob: {$this->library->name} library files are empty, nothing to parse.");

            return;
        }

        $files = File::query()
            ->where('library_id', $this->library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        $toParse = $this->findFilesToParse($this->paths, $files);
        $toDelete = $this->findFilesToDelete($this->paths, $files);
        $this->deleteFiles($toDelete, $this->library->name);

        $files = [];
        foreach ($toParse as $path) {
            $file = BookFileItem::make($path, $this->library->id);
            if (! $file) {
                continue;
            }

            $files[] = $file;
        }
        $count = count($files);

        $i = 0;
        foreach ($files as $file) {
            $i++;
            BookJob::dispatch($file, "{$i}/{$count}", $this->library->name, $this->fresh);
        }

        CleanDispatchJob::dispatch();
        if ($this->fresh) {
            ScoutJob::dispatch();
        }
    }

    /**
     * @param  string[]  $files
     */
    private function findFilesToParse(array $paths, array $files): array
    {
        $paths = array_filter($paths, function (string $path) use ($files) {
            if (! in_array($path, $files, true)) {
                return true;
            }

            return false;
        });

        return array_values($paths);
    }

    /**
     * @param  string[]  $files
     */
    private function findFilesToDelete(array $paths, array $files): array
    {
        $files = array_filter($files, function (string $file) use ($paths) {
            if (! in_array($file, $paths, true)) {
                return true;
            }

            return false;
        });

        return array_values($files);
    }

    private function deleteFiles(array $filesToDelete, string $libraryName)
    {
        $files = File::query()
            ->whereIn('path', $filesToDelete)
            ->get();

        Journal::info("BooksDispatchJob: delete {$files->count()} files for {$libraryName}...", [
            'files' => $files->pluck('path')->toArray(),
        ]);

        foreach ($files as $file) {
            $file->delete();
        }
    }
}
