<?php

namespace App\Models;

use App\Models\Traits\HasAuthors;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasLanguage;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasTagsAndGenres;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Tags\HasTags;

class Book extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use HasClassName;
    use HasCovers;
    use HasAuthors;
    use HasFavorites;
    use HasComments;
    use HasSelections;
    use HasLanguage;
    use HasTagsAndGenres;
    use Searchable;

    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'contributor',
        'description',
        'released_on',
        'rights',
        'volume',
        'page_count',
        'maturity_rating',
        'disabled',
    ];
    protected $with = [
        'language',
        'authors',
        'media',
    ];
    protected $casts = [
        'released_on' => 'datetime',
        'disabled' => 'boolean',
    ];

    /**
     * Manage EPUB files with spatie/laravel-medialibrary.
     */
    public function getEpubAttribute(): string|null
    {
        return $this->getFirstMediaUrl('epubs');
    }

    public function getShowRelatedLinkAttribute(): string
    {
        return route('api.v1.books.related', [
            'author_slug' => $this->meta_author,
            'book_slug' => $this->slug,
        ]);
    }

    // public function getShowLinkAttribute(): string
    // {
    //     return route('api.v1.users.show', [
    //         'slug' => $this->slug,
    //     ]);
    // }

    public function getEpubPathAttribute(): string|null
    {
        $full = null;
        $path = $this->getFirstMediaPath('epubs');
        $path = explode('app/public', $path);
        if (array_key_exists(1, $path)) {
            $path = $path[1];
            $full = config('app.url').'/storage'.$path;
            $full = str_replace('\\', '/', $full);
        }

        return $full;
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
     * Define sort name for `/api/books` with serie-volume-book.
     */
    public function getSortNameAttribute(): string
    {
        $serie = null;
        if ($this->serie) {
            // @phpstan-ignore-next-line
            $volume = strlen($this->volume) < 2 ? '0'.$this->volume : $this->volume;
            $serie = $this->serie->title_sort.' '.$volume;
            $serie = Str::slug($serie).'_';
        }
        $title = Str::slug($this->title_sort);

        return "{$serie}{$title}";
    }

    public function scopeWhereSerieTitleIs(Builder $query, $title): Builder
    {
        return $query
            ->whereRelation('serie', 'title', '=', $title)
        ;
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'picture' => $this->cover_thumbnail,
            'released_on' => $this->released_on,
            'author' => $this->authors_names,
            'isbn' => $this->identifier->isbn ?? null,
            'isbn13' => $this->identifier->isbn13 ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function identifier(): BelongsTo
    {
        return $this->belongsTo(Identifier::class);
    }

    public function googleBook(): BelongsTo
    {
        return $this->belongsTo(GoogleBook::class);
    }
}
