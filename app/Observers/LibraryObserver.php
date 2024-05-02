<?php

namespace App\Observers;

use App\Models\Library;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class LibraryObserver
{
    /**
     * Handle the Library "created" event.
     */
    public function created(Library $library): void
    {
        Cache::forget(Library::CACHE_KEY);

        $this->checkPath($library);
    }

    /**
     * Handle the Library "updated" event.
     */
    public function updated(Library $library): void
    {
        Cache::forget(Library::CACHE_KEY);

        $this->checkPath($library);
    }

    /**
     * Handle the Library "deleted" event.
     */
    public function deleted(Library $library): void
    {
        Cache::forget(Library::CACHE_KEY);
    }

    /**
     * Handle the Library "restored" event.
     */
    public function restored(Library $library): void
    {
        Cache::forget(Library::CACHE_KEY);
    }

    /**
     * Handle the Library "force deleted" event.
     */
    public function forceDeleted(Library $library): void
    {
        Cache::forget(Library::CACHE_KEY);
    }

    private function checkPath(Library $library): void
    {
        if (! $library->isDirty('path')) {
            return;
        }

        while (substr($library->path, -1) === DIRECTORY_SEPARATOR) {
            $library->path = substr($library->path, 0, -1);
            $library->saveQuietly();
        }

        $exists = file_exists($library->path);

        $paths = explode(DIRECTORY_SEPARATOR, $library->path);
        $library->path_name = end($paths);

        $library->path_is_valid = $exists;
        $library->saveQuietly();

        if (! $exists) {
            Notification::make()
                ->title("Library {$library->name} path not found")
                ->sendToDatabase(User::getCurrentUser());
        }
    }
}
