<?php

namespace App\Models;

use App\Enums\TagTypeEnum;
use App\Traits\HasNegligible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Queryable;
use Spatie\QueryBuilder\AllowedFilter;

class Tag extends Model
{
    use HasFactory;
    use HasNegligible;
    use HasSlug;
    use Queryable;

    protected $query_default_sort = 'slug';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'name',
        'slug',
        'type',
        'books_count',
        'series_count',
        'created_at',
        'updated_at',
    ];

    protected $query_full = true;

    // protected $query_resource = TagCollection::class;

    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    protected $casts = [
        'type' => TagTypeEnum::class,
    ];

    protected $withCount = [
        // 'books',
        // 'series',
    ];

    protected $appends = [
    ];

    // public function getShowLinkAttribute(): string
    // {
    //     return route('api.tags.show', [
    //         'tag_slug' => $this->slug,
    //     ]);
    // }

    // public function getBooksLinkAttribute(): string
    // {
    //     return route('api.tags.show.books', [
    //         'tag_slug' => $this->slug,
    //     ]);
    // }

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

    public function series(): MorphToMany
    {
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
            AllowedFilter::scope('negligible', 'whereIsNegligible')->default(true),
            AllowedFilter::scope('type', 'whereTypeIs'),
        ];
    }
}
