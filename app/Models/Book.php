<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBookType;
use App\Traits\HasClassName;
use App\Traits\HasCovers;
use App\Traits\HasFavorites;
use App\Traits\HasLanguage;
use App\Traits\HasReviews;
use App\Traits\HasSelections;
use App\Traits\HasSlug;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;

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
    use HasClassName;
    use Searchable;

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
        $app = config('bookshelves.slug');

        return "{$app}_books";
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
}
