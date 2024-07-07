<?php

namespace App\Observers;

use App\Models\AudiobookTrack;
use App\Models\Book;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        if ($book->file()->exists()) {
            $book->file()->delete();
        }

        if ($book->audiobookTracks()->exists()) {
            $book->audiobookTracks()->each(function (AudiobookTrack $track) {
                if ($track->file()->exists()) {
                    $track->file()->delete();
                }

                $track->delete();
            });
        }
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}
