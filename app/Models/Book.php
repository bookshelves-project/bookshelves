<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBookFiles;
use App\Traits\HasBookType;
use App\Traits\HasCovers;
use App\Traits\HasLanguage;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
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

class Book extends Model implements HasMedia
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
    use HasUlids;
    use IsEntity;
    use Queryable;

    protected $slug_with = 'title';

    protected $query_default_sort = 'slug';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'title',
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
        'contributor',
        'description',
        'released_on',
        'audiobook_narrators',
        'audiobook_chapters',
        'rights',
        'volume',
        'page_count',
        'is_maturity_rating',
        'is_hidden',
        'format',
        'isbn10',
        'isbn13',
        'identifiers',
        'language_slug',
        'serie_id',
        'publisher_id',
        'physical_path',
        'extension',
        'mime_type',
        'google_book_parsed_at',
        'added_at',
    ];

    protected $appends = [
        'isbn',
        'volume_pad',
        'download_link',
    ];

    protected $casts = [
        'released_on' => 'date',
        'audiobook_narrators' => 'array',
        'audiobook_chapters' => 'array',
        'is_hidden' => 'boolean',
        'format' => BookFormatEnum::class,
        'identifiers' => 'array',
        'volume' => 'integer',
        'page_count' => 'integer',
        'is_maturity_rating' => 'boolean',
        'google_book_parsed_at' => 'datetime',
        'added_at' => 'datetime',
    ];

    protected $with = [
        'authors',
        'serie',
        'language',
    ];

    protected $withCount = [
        // 'tags',
    ];

    public function getDownloadLinkAttribute(): string
    {
        return route('downloads.show', [
            'book_id' => $this->id,
        ]);
    }

    public function getIsbnAttribute(): ?string
    {
        return $this->isbn13 ?? $this->isbn10;
    }

    public function getVolumePadAttribute(): ?string
    {
        if (! $this->volume) {
            return null;
        }

        return str_pad(strval($this->volume), 2, '0', STR_PAD_LEFT);
    }

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

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function audiobooks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Audiobook::class);
    }

    public function toSearchableArray()
    {
        $this->loadMissing(['serie', 'authors', 'tags']);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'picture' => $this->cover_thumbnail,
            'released_on' => $this->released_on,
            'author' => $this->authors_names,
            'serie' => $this->serie?->title,
            'isbn10' => $this->isbn10,
            'isbn13' => $this->isbn13,
            'tags' => $this->tags_string,
        ];
    }

    protected function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['title', 'serie'])),
            AllowedFilter::exact('id'),
            AllowedFilter::partial('title'),
            AllowedFilter::callback('serie',
                fn (Builder $query, $value) => $query->whereHas('serie',
                    fn (Builder $query) => $query->where('title', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::partial('volume'),
            AllowedFilter::callback('authors',
                fn (Builder $query, $value) => $query->whereHas('authors',
                    fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::exact('is_hidden'),
            AllowedFilter::exact('released_on'),
            AllowedFilter::exact('type'),
            AllowedFilter::scope('types', 'whereTypesIs'),
            AllowedFilter::callback('language',
                fn (Builder $query, $value) => $query->whereHas('language',
                    fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::scope('languages', 'whereLanguagesIs'),
            AllowedFilter::callback('publisher',
                fn (Builder $query, $value) => $query->whereHas('publisher',
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
