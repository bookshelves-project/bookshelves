<?php

namespace App\Models\Traits;

/**
 * Manage tags and genres with `spatie/laravel-tags`.
 */
trait HasTagsAndGenres
{
    public function getTagsListAttribute()
    {
        return $this->tags()->whereType('tag')->get();
    }

    public function getGenresListAttribute()
    {
        return $this->tags()->whereType('genre')->get();
    }
}
