<?php

namespace App\Models;

use App\Traits\HasBooksCollection;
use App\Traits\HasCovers;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property null|int $books_count
 * @property null|int $series_count
 * @property \App\Enums\BookTypeEnum|null $type
 */
class Author extends Model implements HasMedia
{
    use HasBooksCollection;
    use HasCovers;
    use HasFactory;
    use HasMetaClass;
    use HasSearchableName, Searchable {
        HasSearchableName::searchableAs insteadof Searchable;
    }
    use HasSlug;
    use HasTagsAndGenres;
    use HasUlids;
    use IsEntity;
    use Queryable;

    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'role',
        'description',
        'link',
        'note',
    ];

    protected $query_default_sort = 'lastname';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'firstname',
        'lastname',
        'name',
        'role',
        'books_count',
        'series_count',
        'created_at',
        'updated_at',
    ];

    protected $query_limit = 32;

    protected $appends = [
        'title',
    ];

    protected $withCount = [
        'books',
        'series',
    ];

    public function getTitleAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get all of the books that are assigned this author.
     */
    public function books(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')
            ->orderBy('slug_sort')
            ->orderBy('volume');
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'authorable')
            ->orderBy('slug_sort')
            ->withCount('books');
    }

    public function scopeWhereFirstCharacterIs(Builder $query, string $character): Builder
    {
        return $query->where('lastname', 'like', "{$character}%");
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'cover' => $this->cover_thumbnail,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['firstname', 'lastname', 'name'])),
            AllowedFilter::partial('firstname'),
            AllowedFilter::partial('lastname'),
            AllowedFilter::exact('role'),
        ];
    }
}
