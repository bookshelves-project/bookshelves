<?php

namespace App\Traits;

use App\Enums\BookTypeEnum;
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

    public function scopeWhereIsAudiobook(Builder $query): Builder
    {
        return $query->where('type', BookTypeEnum::audiobook);
    }

    public function scopeWhereIsBook(Builder $query): Builder
    {
        return $query->where('type', BookTypeEnum::book);
    }

    public function scopeWhereIsComic(Builder $query): Builder
    {
        return $query->where('type', BookTypeEnum::comic);
    }

    public function scopeWhereIsManga(Builder $query): Builder
    {
        return $query->where('type', BookTypeEnum::manga);
    }
}
