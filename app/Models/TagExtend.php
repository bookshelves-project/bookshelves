<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\Tag;

/**
 * @property null|int $books_count
 */
class TagExtend extends Tag
{
    use HasFirstChar;

    protected $table = 'tags';

    protected $appends = [
        'first_char',
    ];

    public function getShowLinkAttribute(): string
    {
        return route('api.v1.tags.show', [
            'tag_slug' => $this->slug,
        ]);
    }

    public function getShowBooksLinkAttribute(): string
    {
        return route('api.v1.tags.show.books', [
            'tag_slug' => $this->slug,
        ]);
    }

    public function scopeWhereTypeIs(Builder $query, string $type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeWhereShowNegligible(Builder $query, string $show_negligible)
    {
        $show_negligible = filter_var($show_negligible, FILTER_VALIDATE_BOOLEAN);

        return $show_negligible ? $query : $query->whereHas('books', count: 3);
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
