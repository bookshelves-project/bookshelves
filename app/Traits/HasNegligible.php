<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Negligible books.
 *
 * - scope `whereNegligibleIs` with `where` on `negligible` for books cout under 3
 */
trait HasNegligible
{
    public function scopeWhereIsNegligible(Builder $query, string $negligible): Builder
    {
        $negligible = filter_var($negligible, FILTER_VALIDATE_BOOLEAN);

        return $negligible ? $query : $query->whereHas('books', count: 3);
        // return $query;
    }
}
