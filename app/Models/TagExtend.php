<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\Tag;

class TagExtend extends Tag
{
    use HasFirstChar;

    protected $table = 'tags';

    protected $appends = [
        'first_char',
    ];

    public function scopeWhereTypeIs(Builder $query, string $type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeWhereIsNegligible(Builder $query, string $negligible)
    {
        $negligible = filter_var($negligible, FILTER_VALIDATE_BOOLEAN);

        return $negligible ? $query : $query->whereHas('books', count: 3);
    }

    public function books(): MorphToMany
    {
        return $this->morphToMany(
            related: Book::class,
            name: 'taggable',
            table: 'taggables',
            foreignPivotKey: 'tag_id',
            relatedPivotKey: 'taggable_id',
            parentKey: 'id',
            relatedKey: 'id',
            inverse: true
        );
    }
}
