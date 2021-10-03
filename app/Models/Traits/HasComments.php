<?php

namespace App\Models\Traits;

use App\Models\Commentable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Manage comments with `MorphToMany` `comments`.
 */
trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Commentable::class, 'commentable')->orderBy('created_at', 'DESC');
    }
}
