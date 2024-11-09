<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use App\Enums\LibraryTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBooksCollection;
use App\Traits\HasCovers;
use App\Traits\HasLanguage;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use App\Utils\NitroStream;
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

    protected $query_default_sort = 'slug';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = [
        'id',
        'title',
        'authors',
        'books_count',
        'language',
        'created_at',
        'updated_at',
    ];

    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'parsed_at',
    ];

    protected $appends = [
        'download_url',
        'nitro_stream_url',
    ];

    protected $casts = [
        'parsed_at' => 'datetime',
    ];

    protected $with = [];

    protected $withCount = [];

    public function getFormatIconAttribute(): string
    {
        $this->loadMissing('library');

        return $this->library->type->value;
    }

    public function getBooksLinkAttribute(): string
    {
        return route('api.series.show.books', [
            'author' => $this->meta_author,
            'serie' => $this->slug,
        ]);
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('download.serie', ['serie_id' => $this->id]);
    }

    public function getNitroStreamUrlAttribute(): string
    {
        $this->loadMissing('library');
        $type = null;
        if ($this->library->type === LibraryTypeEnum::audiobook) {
            $type = 'audiobook-serie';
        }

        return NitroStream::writeUrl('zip', $this->id, $type);
    }

    public function getRouteAttribute(): string
    {
        return route('series.show', [
            'library' => $this->library?->slug ?? 'unknown',
            'serie' => $this->slug,
        ]);
    }

    public function getFormatAttribute(): ?BookFormatEnum
    {
        $this->loadMissing('books');

        return $this->books->first()?->format ?? null;
    }

    public function getFirstCharAttribute()
    {
        return strtoupper(substr(Str::slug($this->title), 0, 1));
    }

    public function scopeWhereFirstChar(Builder $query, string $char): Builder
    {
        return $query->whereRaw('UPPER(SUBSTR(slug, 1, 1)) = ?', [strtoupper($char)]);
    }

    public function scopeWhereLibraryIs(Builder $query, Library $library): Builder
    {
        return $query->where('library_id', $library->id);
    }

    public function scopeWhereLibraryType(Builder $query, LibraryTypeEnum $type): Builder
    {
        return $query->whereRelation('library', 'type', $type);
    }

    public function scopeWhereHasBooks(Builder $query): Builder
    {
        return $query->whereRelation('library', 'type', LibraryTypeEnum::book);
    }

    public function scopeWhereTagIs(Builder $query, Tag $tag): Builder
    {
        return $query->whereHas('tags', fn (Builder $query) => $query->where('tags.id', $tag->id));
    }

    public function books(): HasMany
    {
        // Get Books into Serie, by volume order.
        return $this->hasMany(Book::class)
            ->where('is_hidden', false)
            ->orderBy('volume');
    }

    public function library(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function toSearchableArray()
    {
        $this->loadMissing(['authors', 'tags', 'media', 'library']);

        return [
            'id' => $this->id,
            'title' => $this->title,
            // 'cover' => $this->cover_thumbnail,
            'library' => $this->library?->type_label,
        ];
    }

    protected function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['title'])),
            AllowedFilter::partial('title'),
            AllowedFilter::partial('authors'),
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
