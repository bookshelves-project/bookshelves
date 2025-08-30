<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use App\Enums\LibraryTypeEnum;
use App\Observers\BookObserver;
use App\Traits\HasAuthors;
use App\Traits\HasBookFiles;
use App\Traits\HasCovers;
use App\Traits\HasLanguage;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use App\Utils\NitroStream;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueryBuilder\AllowedFilter;

#[ObservedBy(BookObserver::class)]
class Book extends Model implements HasMedia
{
    use HasAuthors;
    use HasBookFiles;
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
        'slug',
        'authors',
        'volume',
        'isbn',
        'publisher',
        'released_on',
        'created_at',
        'updated_at',
        'added_at',
        'calibre_added_at',
    ];

    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'format',
        'contributor',
        'description',
        'released_on',
        'audiobook_narrators',
        'audiobook_chapters',
        'is_audiobook',
        'rights',
        'volume',
        'page_count',
        'is_hidden',
        'is_selected',
        'isbn10',
        'isbn13',
        'identifiers',
        'language_slug',
        'serie_id',
        'publisher_id',
        'to_notify',
        'added_at',
    ];

    protected $appends = [
        'isbn',
        'volume_pad',
        'route',
        'download_url',
        'nitro_stream_url',
    ];

    protected $casts = [
        'format' => BookFormatEnum::class,
        'released_on' => 'date',
        'audiobook_narrators' => 'array',
        'audiobook_chapters' => 'array',
        'is_audiobook' => 'boolean',
        'is_hidden' => 'boolean',
        'is_selected' => 'boolean',
        'identifiers' => 'array',
        'volume' => 'float',
        'page_count' => 'integer',
        'to_notify' => 'boolean',
        'added_at' => 'datetime',
        'calibre_added_at' => 'datetime',
    ];

    protected $with = [
        'file',
    ];

    protected $withCount = [];

    public function getFormatIconAttribute(): string
    {
        $this->loadMissing('library');

        return $this->library->type->value;
    }

    public function getAudiobookChaptersNumberAttribute(): ?int
    {
        if (! $this->is_audiobook) {
            return null;
        }

        if (! is_array($this->audiobook_chapters)) {
            return null;
        }

        $i = 0;
        foreach ($this->audiobook_chapters as $chapter) {
            $i++;
        }

        return $i;
    }

    public function getAudiobookDurationAttribute(): ?string
    {
        if (! $this->is_audiobook) {
            return null;
        }

        if (! is_array($this->audiobook_chapters)) {
            return null;
        }

        $duration = 0;
        foreach ($this->audiobookTracks as $track) {
            $duration += $track->duration;
        }

        return gmdate('H:i:s', intval($duration));
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('download.book', ['book_id' => $this->id]);
    }

    public function getNitroStreamUrlAttribute(): string
    {
        return NitroStream::writeUrl(id: $this->id, table: 'books');
    }

    public function getHumanNameAttribute(bool $slug = false): string
    {
        $this->loadMissing(['serie', 'authorMain', 'library', 'language', 'audiobookTracks']);

        $name = '';

        if ($this->serie) {
            $name .= "{$this->serie->title} {$this->volume_pad} ";
        }

        $name .= "{$this->title} ";

        if ($this->authorMain) {
            $name .= "{$this->authorMain->name} ";
        }

        $name .= "{$this->language->name}";

        if ($slug) {
            return NitroStream::clearSpaces($name);
        }

        return $name;
    }

    public function getRouteAttribute(): string
    {
        $this->loadMissing('library');

        return route('books.show', [
            'library' => $this->library?->slug ?? 'unknown',
            'book' => $this->slug,
        ]);
    }

    public function getIsbnAttribute(): ?string
    {
        return $this->isbn13 ?? $this->isbn10;
    }

    public function getVolumePadAttribute(): ?string
    {
        if ($this->volume === null) {
            return null;
        }

        return str_pad(strval($this->volume), 2, '0', STR_PAD_LEFT);
    }

    public function getReaderUrlAttribute(): string
    {
        return route('reader.show', [
            'library' => $this->library->id,
            'book' => $this->slug,
        ]);
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
        return $query->whereBetween('released_on', [Carbon::parse($startDate), Carbon::parse($endDate)]);
    }

    public function scopeWhereLibraryIs(Builder $query, Library $library): Builder
    {
        return $query->where('library_id', $library->id);
    }

    public function scopeWhereLibraryType(Builder $query, LibraryTypeEnum $type): Builder
    {
        return $query->whereRelation('library', 'type', $type);
    }

    public function scopeWhereTagIs(Builder $query, Tag $tag): Builder
    {
        return $query->whereHas('tags', fn ($query) => $query->where('tag_id', $tag->id));
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function audiobookTracks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AudiobookTrack::class);
    }

    public function library(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function getBookIndexPath(): string
    {
        $this->loadMissing('library');

        return storage_path('app'.DIRECTORY_SEPARATOR.'index'.DIRECTORY_SEPARATOR.'book'.DIRECTORY_SEPARATOR.$this->library->slug.DIRECTORY_SEPARATOR.$this->id.'.dat');
    }

    public function getRelated(): Collection
    {
        if ($this->tags->count() === 0) {
            return collect();
        }

        // get related books by tags, same lang
        $relatedBooks = Book::withAllTags($this->tags)
            ->with(['authors', 'serie', 'media', 'language'])
            ->get();

        if ($this->serie) {
            // get serie of current book
            $serie = Serie::query()->where('slug', $this->serie->slug)->first();
            // get books of this serie
            $serieBooks = $serie->books()->with(['serie', 'media'])->get();

            // remove all books from this serie
            $filtered = $relatedBooks->filter(function (Book $relatedBook) use ($serieBooks) {
                foreach ($serieBooks as $serieBook) {
                    if ($relatedBook->serie) {
                        return $relatedBook->serie->slug != $serieBook->serie->slug;
                    }
                }
            });
            $relatedBooks = $filtered;
        }

        // remove current book
        $relatedBooks = $relatedBooks->filter(fn ($related_book) => $related_book->slug != $this->slug);

        // get series of related
        $seriesList = collect();

        foreach ($relatedBooks as $key => $book) {
            if ($book->serie) {
                $seriesList->add($book->serie);
            }
        }

        // remove all books of series
        $relatedBooks = $relatedBooks->filter(fn (Book $book) => $book->serie === null);
        // unique on series
        $seriesList = $seriesList->unique();

        // merge books and series
        $relatedBooks = $relatedBooks->merge($seriesList);
        $relatedBooks = $relatedBooks->loadMissing(['language', 'media', 'authors']);

        // sort entities
        return $relatedBooks->sortBy('slug_sort');
    }

    public function toSearchableArray()
    {
        $this->loadMissing(['serie', 'authors', 'tags', 'media', 'library']);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'cover' => $this->cover_thumbnail,
            'serie' => $this->serie?->title,
            'library' => $this->library?->type_label,
            'isbn10' => $this->isbn10,
            'isbn13' => $this->isbn13,
        ];
    }

    protected function setQueryAllowedFilters(): array
    {
        return [
            // AllowedFilter::custom('q', new GlobalSearchFilter(['title', 'serie'])),
            AllowedFilter::exact('id'),
            AllowedFilter::partial('title'),
            // AllowedFilter::callback('serie',
            //     fn (Builder $query, $value) => $query->whereHas('serie',
            //         fn (Builder $query) => $query->where('title', 'like', "%{$value}%")
            //     )
            // ),
            AllowedFilter::exact('volume'),
            // AllowedFilter::callback('authors',
            //     fn (Builder $query, $value) => $query->whereHas('authors',
            //         fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
            //     )
            // ),
            // AllowedFilter::exact('released_on'),
            AllowedFilter::callback('language',
                fn (Builder $query, $value) => $query->whereHas('language',
                    fn (Builder $query) => $query->where('slug', '=', $value)
                )
            ),
            // AllowedFilter::scope('languages', 'whereLanguagesIs'),
            // AllowedFilter::callback('publisher',
            //     fn (Builder $query, $value) => $query->whereHas('publisher',
            //         fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
            //     )
            // ),
            // AllowedFilter::scope('disallow_serie', 'whereDisallowSerie'),
            // AllowedFilter::scope('language', 'whereLanguagesIs'),
            // AllowedFilter::scope('published', 'publishedBetween'),
            // AllowedFilter::scope('is_hidden', 'whereIsHidden'),
            // AllowedFilter::scope('author_like', 'whereAuthorIsLike'),
            // AllowedFilter::scope('tags_all', 'whereTagsAllIs'),
            // AllowedFilter::scope('tags', 'whereTagsIs'),
            // AllowedFilter::scope('isbn', 'whereIsbnIs'),
        ];
    }
}
