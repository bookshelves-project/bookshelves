<?php

namespace App\Models\Traits;

use App\Models\Review;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Manage reviews with `MorphToMany` `reviews`.
 */
trait HasReviews
{
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviews', 'reviewable_type', 'reviewable_id')->orderBy('created_at', 'DESC');
    }

    public function getReviewsLinkAttribute()
    {
        return route('api.entities.reviews', [
            'entity' => $this->getClassName(),
            'entity_id' => $this->id,
        ]);
    }
}
