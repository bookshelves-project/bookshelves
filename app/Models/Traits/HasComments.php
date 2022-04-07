<?php

namespace App\Models\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Manage comments with `MorphToMany` `comments`.
 */
trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'comments', 'commentable_type', 'commentable_id')->orderBy('created_at', 'DESC');
    }

    public function getCommentsLinkAttribute()
    {
        return route('api.entities.comments', [
            'entity' => $this->getClassName(),
            'entity_id' => $this->id,
        ]);
    }
}
