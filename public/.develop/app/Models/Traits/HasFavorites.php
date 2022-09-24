<?php

namespace App\Models\Traits;

use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Manage favorites with `MorphToMany` `favoritables`.
 */
trait HasFavorites
{
    public function getIsFavoriteAttribute(): bool
    {
        $is_favorite = false;
        if (Auth::check()) {
            $entity = $this->getClassNamespace()::whereSlug($this->slug)->first();

            $checkIfFavorite = $this->getClassNamespace()::find($entity->id)->favorites;
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
