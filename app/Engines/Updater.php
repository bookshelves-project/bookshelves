<?php

namespace App\Engines;

use App\Facades\Bookshelves;
use App\Models\File;
use App\Models\Library;
use App\Utils;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Update library with new and lost files.
 */
class Updater
{
    public function __construct(
        public Library $library,
        public array $paths = [],
        public bool $fresh = false,
    ) {}

    /**
     * Update the library with the given paths.
     *
     * @param  string[]  $paths
     */
    public static function make(Library $library, array $paths, bool $fresh = false): self
    {
        Journal::debug('Updater: create BookJob for each item...');
        $self = new self($library, $paths, $fresh);

        if ($self->fresh) {
            Journal::info('Updater: Fresh install!');

            return $self;
        }
        $self->handle();

        return $self;
    }

    private function handle(): void
    {
        if (empty($this->paths)) {
            Journal::error("Updater: {$this->library->name} library files are empty, nothing to parse.");

            return;
        }

        $files = File::query()
            ->where('library_id', $this->library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        $new_files = $this->findNewFiles($this->paths, $files);
        $lost_files = $this->findLostFiles($this->paths, $files);
        $this->removeFiles($lost_files, $this->library->name);

        $data = Utils::unserialize($this->library->getIndexLibraryPath());

        $count_new_files = count($new_files);
        $data['file_paths'] = $new_files;
        $data['count'] = $count_new_files;
        Utils::serialize($this->library->getIndexLibraryPath(), $data);

        if (Bookshelves::verbose()) {
            $count_lost_files = count($lost_files);
            Journal::debug("Updater: found {$count_new_files} new files to add for {$this->library->name} library.");
            Journal::debug("Updater: found {$count_lost_files} lost files to remove for {$this->library->name} library.");
        }
    }

    /**
     * Find new files to parse.
     *
     * @param  string[]  $paths
     * @param  string[]  $files
     * @return string[]
     */
    private function findNewFiles(array $paths, array $files): array
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
     * Find lost files to remove.
     *
     * @param  string[]  $paths
     * @param  string[]  $files
     * @return string[]
     */
    private function findLostFiles(array $paths, array $files): array
    {
        $files = array_filter($files, function (string $file) use ($paths) {
            if (! in_array($file, $paths, true)) {
                return true;
            }

            return false;
        });

        return array_values($files);
    }

    /**
     * Delete files.
     *
     * @param  string[]  $lost_files  Lost files paths.
     */
    private function removeFiles(array $lost_files, string $library_name): void
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $files */
        $files = File::query()
            ->with('book')
            ->whereIn('path', $lost_files)
            ->get();

        Journal::info("BooksDispatchJob: delete {$files->count()} files for {$library_name}...", [
            'files' => $files->pluck('path')->toArray(),
        ]);

        foreach ($files as $file) {
            $file->delete();
        }
    }
}
