<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

/**
 * Manage favorites with `MorphToMany` `favoritables`.
 */
trait HasFavorites
{
    public function getIsFavoriteAttribute(): bool
    {
        $is_favorite = false;

        /** @var Book|Author|Serie */
        $that = $this;

        if (Auth::check()) {
            $entity = $that->meta_class_namespaced::whereSlug($this->slug)->first();

            $checkIfFavorite = $that->meta_class_namespaced::find($entity->id)->favorites;

            if (! count($checkIfFavorite) < 1) {
                $is_favorite = true;
            }
        }

        return $is_favorite;
    }

    public function favorites(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favoritable')->withTimestamps();
    }
}
