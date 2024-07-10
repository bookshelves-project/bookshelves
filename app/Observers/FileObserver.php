<?php

namespace App\Observers;

use App\Models\AudiobookTrack;
use App\Models\File;

class FileObserver
{
    /**
     * Handle the File "created" event.
     */
    public function created(File $file): void
    {
        //
    }

    /**
     * Handle the File "updated" event.
     */
    public function updated(File $file): void
    {
        //
    }

    /**
     * Handle the File "deleted" event.
     */
    public function deleted(File $file): void
    {
        if ($file->book()->exists()) {
            $file->book()->delete();
        }

        if ($file->audiobookTracks()->exists()) {
            $file->audiobookTracks()->each(function (AudiobookTrack $track) {
                if ($track->file()->exists()) {
                    $track->file()->delete();
                }

                $track->delete();
            });
        }
    }

    /**
     * Handle the File "restored" event.
     */
    public function restored(File $file): void
    {
        //
    }

    /**
     * Handle the File "force deleted" event.
     */
    public function forceDeleted(File $file): void
    {
        //
    }
}
