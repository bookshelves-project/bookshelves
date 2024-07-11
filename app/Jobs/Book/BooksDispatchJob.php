<?php

namespace App\Jobs\Book;

use App\Engines\Book\File\BookFileItem;
use App\Jobs\Clean\CleanDispatchJob;
use App\Jobs\Clean\ScoutJob;
use App\Jobs\NotifierJob;
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
     */
    public function __construct(
        public Library $library,
        public bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::debug('BooksDispatchJob: create BookJob for each item...');

        $bookFiles = (array) json_decode(file_get_contents($this->library->getJsonPath()), true);

        $files = File::query()
            ->where('library_id', $this->library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        $toParse = $this->findFilesToParse($bookFiles, $files);
        $toDelete = $this->findFilesToDelete($bookFiles, $files);
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
        } else {
            NotifierJob::dispatch($this->library);
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
