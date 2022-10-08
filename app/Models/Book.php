<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBookFiles;
use App\Traits\HasBookType;
use App\Traits\HasCovers;
use App\Traits\HasFavorites;
use App\Traits\HasLanguage;
use App\Traits\HasReviews;
use App\Traits\HasSelections;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property null|int $reviews_count
 */
class Book extends Model implements HasMedia
{
    use HasFactory;
    use HasAuthors;
    use HasSlug;
    use IsEntity;
    use HasFavorites;
    use HasReviews;
    use HasLanguage;
    use HasSelections;
    use HasTagsAndGenres;
    use HasBookType;
    use HasCovers;
    use HasSelections;
    use HasMetaClass;
    use HasBookFiles;
    use Searchable;
    use Queryable;
    use HasSearchableName;

    protected $query_default_sort = 'slug_sort';
    protected $query_allowed_sorts = ['id', 'title', 'slug_sort', 'type', 'serie', 'authors', 'volume', 'isbn', 'publisher', 'released_on', 'created_at', 'updated_at'];
    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'slug_sort',
        'contributor',
        'description',
        'released_on',
        'rights',
        'volume',
        'page_count',
        'maturity_rating',
        'is_disabled',
        'type',
        'isbn10',
        'isbn13',
        'identifiers',
        'language_slug',
        'serie_id',
        'publisher_id',
    ];

    protected $appends = [
        'isbn',
    ];

    protected $casts = [
        'released_on' => 'datetime',
        'is_disabled' => 'boolean',
        'type' => BookTypeEnum::class,
        'identifiers' => 'array',
        'volume' => 'integer',
        'page_count' => 'integer',
    ];

    protected $withCount = [
        'tags',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('epub');
    }

    public function getIsbnAttribute(): ?string
    {
        return $this->isbn13 ?? $this->isbn10;
    }

    /**
     * Scope.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_disabled', false);
    }

    public function scopeWhereDisallowSerie(Builder $query, string $has_not_serie): Builder
    {
        $has_not_serie = filter_var($has_not_serie, FILTER_VALIDATE_BOOLEAN);

        return $has_not_serie ? $query->whereDoesntHave('serie') : $query;
    }

    public function scopePublishedBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query
            ->whereBetween('released_on', [Carbon::parse($startDate), Carbon::parse($endDate)])
        ;
    }

    /**
     * Relationships.
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function googleBook(): BelongsTo
    {
        return $this->belongsTo(GoogleBook::class);
    }

    /**
     * Scout.
     */
    public function searchableAs()
    {
        return $this->searchableNameAs();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            // 'picture' => $this->cover_thumbnail,
            'released_on' => $this->released_on,
            'author' => $this->authors_names,
            'serie' => $this->serie?->title,
            'isbn10' => $this->isbn10,
            'isbn13' => $this->isbn13,
            'tags' => $this->tags_string,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    protected function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['title', 'serie'])),
            AllowedFilter::exact('id'),
            AllowedFilter::partial('title'),
            AllowedFilter::callback(
                'serie',
                fn (Builder $query, $value) => $query->whereHas(
                    'serie',
                    fn (Builder $query) => $query->where('title', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::partial('volume'),
            AllowedFilter::callback(
                'authors',
                fn (Builder $query, $value) => $query->whereHas(
                    'authors',
                    fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::exact('is_disabled'),
            AllowedFilter::exact('released_on'),
            AllowedFilter::exact('type'),
            AllowedFilter::scope('types', 'whereTypesIs'),
            AllowedFilter::callback(
                'language',
                fn (Builder $query, $value) => $query->whereHas(
                    'language',
                    fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::scope('languages', 'whereLanguagesIs'),
            AllowedFilter::callback(
                'publisher',
                fn (Builder $query, $value) => $query->whereHas(
                    'publisher',
                    fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::scope('disallow_serie', 'whereDisallowSerie'),
            AllowedFilter::scope('language', 'whereLanguagesIs'),
            AllowedFilter::scope('published', 'publishedBetween'),
            AllowedFilter::scope('is_disabled', 'whereIsDisabled'),
            AllowedFilter::scope('author_like', 'whereAuthorIsLike'),
            AllowedFilter::scope('tags_all', 'whereTagsAllIs'),
            AllowedFilter::scope('tags', 'whereTagsIs'),
            AllowedFilter::scope('isbn', 'whereIsbnIs'),
        ];
    }
}
