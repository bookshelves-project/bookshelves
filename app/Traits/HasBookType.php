<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasBookType
{
    public function scopeWhereTypesIs(Builder $query, ...$types): Builder
    {
        return $query->whereIn('type', $types);
    }
}
