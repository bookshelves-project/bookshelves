<?php

namespace App\Models;

use App\Enums\TagTypeEnum;
use App\Http\Resources\Tag\TagCollection;
use App\Models\TagExtend as ModelsTagExtend;
use App\Traits\HasFirstChar;
use App\Traits\HasNegligible;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Traits\HasShowRoute;
use Kiwilan\Steward\Traits\Queryable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\Tags\HasTags;

/**
 * @property null|int $books_count
 */
class TagExtend extends \Spatie\Tags\Tag
{
    use HasTags;
    use HasFirstChar;
    use HasNegligible;
    use HasShowRoute;
    use Queryable;

    protected $query_default_sort = 'slug->en';

    protected $query_allowed_sorts = ['id', 'name', 'slug', 'type', 'first_char', 'books_count', 'series_count', 'created_at', 'updated_at'];

    protected $query_full = true;

    protected $query_resource = TagCollection::class;

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

    public function getBooksLinkAttribute(): string
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

    protected function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['name', 'slug', 'type'])),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('books_count'),
            AllowedFilter::partial('series_count'),
            AllowedFilter::partial('first_char'),
            AllowedFilter::scope('negligible', 'whereIsNegligible')->default(true),
            AllowedFilter::scope('type', 'whereTypeIs'),
        ];
    }
}
