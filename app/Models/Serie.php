<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBooksCollection;
use App\Traits\HasCovers;
use App\Traits\HasLanguage;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected $query_default_sort = 'slug_sort';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'title',
        'authors',
        'books_count',
        'language',
        'created_at',
        'updated_at',
        'language',
    ];

    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'slug_sort',
        'slug',
        'type',
        'description',
        'link',
        'wikipedia_parsed_at',
    ];

    protected $casts = [
        'type' => BookTypeEnum::class,
        'wikipedia_parsed_at' => 'datetime',
    ];

    protected $withCount = [
        'books',
    ];

    protected $with = [
        'authors', // for search
        'language',
    ];

    public function getBooksLinkAttribute(): string
    {
        return route('api.series.show.books', [
            'author_slug' => $this->meta_author,
            'serie_slug' => $this->slug,
        ]);
    }

    public function getDownloadLinkFormat(string $format): string
    {
        $format = BookFormatEnum::from($format)->value;

        return route('api.download.serie', [
            'author_slug' => $this->meta_author,
            'serie_slug' => $this->slug,
            'format' => $format,
        ]);
    }

    public function scopeWhereFirstCharacterIs(Builder $query, string $character): Builder
    {
        return $query->where('slug_sort', 'like', "{$character}%");
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
        $this->loadMissing(['authors', 'tags']);

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
