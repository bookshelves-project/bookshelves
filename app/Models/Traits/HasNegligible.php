<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasNegligible
{
    public function scopeWhereIsNegligible(Builder $query, string $negligible): Builder
    {
        $negligible = filter_var($negligible, FILTER_VALIDATE_BOOLEAN);

        return $negligible ? $query : $query->whereHas('books', count: 3);
    }
}
