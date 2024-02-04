<?php

namespace App\Models;

use App\Traits\HasBooksCollection;
use App\Traits\HasCovers;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'name',
        'firstname',
        'lastname',
        'role',
        'description',
        'link',
        'wikipedia_parsed_at',
    ];

    protected $casts = [
        'wikipedia_parsed_at' => 'datetime',
    ];

    protected $query_default_sort = 'name';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
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

    protected $with = [
        'media',
    ];

    protected $withCount = [
        'books',
        'series',
    ];

    public function getTitleAttribute(): string
    {
        return $this->name;
    }

    public function getFirstCharAttribute()
    {
        return strtoupper(substr(Str::slug($this->name), 0, 1));
    }

    public function scopeWhereFirstChar(Builder $query, string $char): Builder
    {
        return $query->whereRaw('UPPER(SUBSTR(name, 1, 1)) = ?', [strtoupper($char)]);
    }

    /**
     * Get all of the books that are assigned this author.
     */
    public function books(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')
            ->orderBy('slug')
            ->orderBy('volume');
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'authorable')
            ->orderBy('slug')
            ->withCount('books');
    }

    public function toSearchableArray()
    {
        $this->loadMissing(['media']);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'cover' => $this->cover_thumbnail,
            'description' => $this->description,
        ];
    }

    public function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['name'])),
            AllowedFilter::partial('name'),
            AllowedFilter::exact('role'),
        ];
    }
}
