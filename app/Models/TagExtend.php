<?php

namespace App\Models;

use App\Enums\TagTypeEnum;
use App\Models\TagExtend as ModelsTagExtend;
use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\HasTags;

/**
 * @property null|int $books_count
 */
class TagExtend extends \Spatie\Tags\Tag
{
    use HasTags;
    use HasFirstChar;

    protected $table = 'tags';

    protected $casts = [
        'type' => TagTypeEnum::class,
    ];

    protected $withCount = [
        'books',
        'series',
    ];

    protected $appends = [
        'first_char',
    ];

    public static function getTagClassName(): string
    {
        return ModelsTagExtend::class;
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.tags.show', [
            'tag_slug' => $this->slug,
        ]);
    }

    public function getShowBooksLinkAttribute(): string
    {
        return route('api.tags.show.books', [
            'tag_slug' => $this->slug,
        ]);
    }

    public function scopeWhereNameEnIs(Builder $query, string $name)
    {
        return $query->where('name->en', '=', $name);
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
        // return $this->morphToMany(Book::class, 'taggable');
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

    public function series(): MorphToMany
    {
        // return $this->morphToMany(Serie::class, 'taggable');
        return $this->morphToMany(
            related: Serie::class,
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
