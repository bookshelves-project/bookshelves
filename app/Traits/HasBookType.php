<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Add scope for book type.
 */
trait HasBookType
{
    public function scopeWhereTypesIs(Builder $query, ...$types): Builder
    {
        return $query->whereIn('type', $types);
    }
}
