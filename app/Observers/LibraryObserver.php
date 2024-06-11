<?php

namespace App\Observers;

use App\Models\Library;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Kiwilan\LaravelNotifier\Facades\Journal;

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

        $library->path_is_valid = $exists;
        $library->saveQuietly();

        if (! $exists) {
            $msg = "Library {$library->name} path not found";
            Notification::make()
                ->title($msg)
                ->color('red')
                ->sendToDatabase(User::getCurrentUser());
            Journal::warning($msg);
        }
    }
}
