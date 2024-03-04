<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBooksCollection;
use App\Traits\HasBookType;
use App\Traits\HasCovers;
use App\Traits\HasLanguage;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property null|int $books_count
 * @property \App\Enums\BookTypeEnum|null $type
 */
class Serie extends Model implements HasMedia
{
    use HasAuthors;
    use HasBooksCollection;
    use HasBookType;
    use HasCovers;
    use HasFactory;
    use HasLanguage;
    use HasMetaClass;
    use HasSearchableName, Searchable {
        HasSearchableName::searchableAs insteadof Searchable;
    }
    use HasTagsAndGenres;
    use HasUlids;
    use IsEntity;
    use Queryable;

    protected $query_default_sort = 'slug';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'title',
        'authors',
        'books_count',
        'language',
        'type',
        'created_at',
        'updated_at',
        'language',
    ];

    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'link',
        'wikipedia_parsed_at',
    ];

    protected $appends = [
        'download_link',
    ];

    protected $casts = [
        'wikipedia_parsed_at' => 'datetime',
        'type' => BookTypeEnum::class,
    ];

    protected $withCount = [
        // 'books',
    ];

    protected $with = [
        // 'authors', // for search
        // 'language',
        // 'media',
    ];

    public function getBooksLinkAttribute(): string
    {
        return route('api.series.show.books', [
            'author_slug' => $this->meta_author,
            'serie_slug' => $this->slug,
        ]);
    }

    public function getDownloadLinkAttribute(): string
    {
        return route('api.downloads.serie', [
            'serie_id' => $this->id,
        ]);
    }

    public function getFirstCharAttribute()
    {
        return strtoupper(substr(Str::slug($this->title), 0, 1));
    }

    public function scopeWhereFirstChar(Builder $query, string $char): Builder
    {
        return $query->whereRaw('UPPER(SUBSTR(slug, 1, 1)) = ?', [strtoupper($char)]);
    }

    public function books(): HasMany
    {
        // Get Books into Serie, by volume order.
        return $this->hasMany(Book::class)
            ->where('is_hidden', false)
            ->orderBy('volume');
    }

    public function toSearchableArray()
    {
        $this->loadMissing(['authors', 'tags', 'media']);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'picture' => $this->cover_thumbnail,
            'author' => $this->authors_names,
            'description' => $this->description,
            'tags' => $this->tags_string,
        ];
    }

    protected function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['title'])),
            AllowedFilter::partial('title'),
            AllowedFilter::partial('authors'),
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
            AllowedFilter::scope('language', 'whereLanguagesIs'),
        ];
    }
}
