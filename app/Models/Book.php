<?php

namespace App\Models;

use App\Engines\Book\Converter\Modules\TagConverter;
use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBookFiles;
use App\Traits\HasBookType;
use App\Traits\HasCovers;
use App\Traits\HasLanguage;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Services\GoogleBook\GoogleBook;
use Kiwilan\Steward\Services\GoogleBook\GoogleBookable;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property null|int $reviews_count
 * @property \App\Enums\BookTypeEnum|null $type
 */
class Book extends Model implements GoogleBookable, HasMedia
{
    use HasAuthors;
    use HasBookFiles;
    use HasBookType;
    use HasCovers;
    use HasFactory;
    use HasLanguage;
    use HasMetaClass;
    use HasSearchableName, Searchable {
        HasSearchableName::searchableAs insteadof Searchable;
    }
    use HasSlug;
    use HasTagsAndGenres;
    use InteractsWithMedia;
    use IsEntity;
    use Queryable;

    protected $slug_with = 'title';

    protected $query_default_sort = 'slug_sort';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'title',
        'slug_sort',
        'type',
        'serie',
        'authors',
        'volume',
        'isbn',
        'publisher',
        'released_on',
        'created_at',
        'updated_at',
    ];

    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'uuid',
        'slug_sort',
        'contributor',
        'description',
        'released_on',
        'rights',
        'volume',
        'page_count',
        'maturity_rating',
        'is_hidden',
        'type',
        'isbn10',
        'isbn13',
        'identifiers',
        'language_slug',
        'serie_id',
        'publisher_id',
        'physical_path',
        'google_book_id',
    ];

    protected $appends = [
        'isbn',
    ];

    protected $casts = [
        'released_on' => 'datetime',
        'is_hidden' => 'boolean',
        'type' => BookTypeEnum::class,
        'identifiers' => 'array',
        'volume' => 'integer',
        'page_count' => 'integer',
    ];

    protected $with = [
        'authors',
        'serie',
        'language',
    ];

    protected $withCount = [
        // 'tags',
    ];

    // public function registerMediaCollections(): void
    // {
    //     $this->addMediaCollection('epub');
    // }

    // public function getDirectDownloadUrlAttribute(): string
    // {
    //     return route('api.download.direct', [
    //         'author_slug' => $this->authors->first()?->slug,
    //         'book_slug' => $this->slug,
    //     ]);
    // }

    public function getIsbnAttribute(): ?string
    {
        return $this->isbn13 ?? $this->isbn10;
    }

    /**
     * Scope.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    public function scopeWhereDisallowSerie(Builder $query, string $has_not_serie): Builder
    {
        $has_not_serie = filter_var($has_not_serie, FILTER_VALIDATE_BOOLEAN);

        return $has_not_serie ? $query->whereDoesntHave('serie') : $query;
    }

    public function scopePublishedBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query
            ->whereBetween('released_on', [Carbon::parse($startDate), Carbon::parse($endDate)]);
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

    public function googleBookConvert(GoogleBook $gbook): self
    {
        $this->google_book_id = $gbook->getBookId();

        if ($gbook->getPublishedDate()) {
            $carbon = Carbon::instance($gbook->getPublishedDate());
            $this->released_on = $this->released_on ?? $carbon->toDateTimeString();
        }
        $this->description = $this->description ?? $gbook->getDescription();
        $this->page_count = $this->page_count ?? $gbook->getPageCount();
        $this->is_maturity_rating = $gbook->isMaturityRating();
        $this->isbn10 = $this->isbn10 ?? $gbook->getIsbn10();
        $this->isbn13 = $this->isbn13 ?? $gbook->getIsbn13();

        // Set publisher
        if (! $this->publisher) {
            $publisher_slug = Str::slug($gbook->getPublisher(), '-');
            $publisher = Publisher::whereSlug($publisher_slug)->first();

            if (! $publisher && $gbook->getPublisher()) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $gbook->getPublisher(),
                    'slug' => $publisher_slug,
                ]);
            }

            if ($publisher) {
                $this->publisher()->associate($publisher);
            }
        }

        // Set tags
        foreach ($gbook->getCategories() as $category) {
            TagConverter::make($category);
        }

        $this->save();

        return $this;
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
            AllowedFilter::exact('is_hidden'),
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
            AllowedFilter::scope('is_hidden', 'whereIsHidden'),
            AllowedFilter::scope('author_like', 'whereAuthorIsLike'),
            AllowedFilter::scope('tags_all', 'whereTagsAllIs'),
            AllowedFilter::scope('tags', 'whereTagsIs'),
            AllowedFilter::scope('isbn', 'whereIsbnIs'),
        ];
    }
}
