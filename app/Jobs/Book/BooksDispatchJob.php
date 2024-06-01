<?php

namespace App\Jobs\Book;

use App\Console\Commands\Bookshelves\AudiobookTracksCommand;
use App\Engines\Book\File\BookFileItem;
use App\Jobs\Author\AuthorsDispatchJob;
use App\Jobs\Clean\CleanDispatchJob;
use App\Jobs\Serie\SeriesDispatchJob;
use App\Models\File;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BooksDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Library $library,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('BooksDispatchJob: create BookJob for each item...');

        $bookFiles = (array) json_decode(file_get_contents($this->library->getJsonPath()), true);
        $count = count($bookFiles);

        $files = File::query()
            ->where('library_id', $this->library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        $toParse = $this->findFilesToParse($bookFiles, $files);
        $toDelete = $this->findFilesToDelete($bookFiles, $files);
        $this->deleteFiles($toDelete, $this->library->name);

        $i = 0;
        foreach ($toParse as $path) {
            $i++;

            $file = BookFileItem::make($path, $this->library->id);
            if (! $file) {
                continue;
            }
            BookJob::dispatch($file, "{$i}/{$count}", $this->library->name);
        }

        if ($this->library->is_audiobook) {
            Artisan::call(AudiobookTracksCommand::class, [
                'library-slug' => $this->library->slug,
            ]);
        }

        AuthorsDispatchJob::dispatch();
        SeriesDispatchJob::dispatch();
        CleanDispatchJob::dispatch();
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
