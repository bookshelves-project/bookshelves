<?php

namespace App\Models;

use App\Engines\ParserEngine;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Media\DownloadFile;
use App\Models\Traits\HasAuthors;
use App\Models\Traits\HasBookType;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasLanguage;
use App\Models\Traits\HasReviews;
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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property null|int $reviews_count
 */
class Book extends Model implements HasMedia
{
    use HasFactory;
    use HasClassName;
    use HasCovers;
    use HasAuthors;
    use HasFavorites;
    use HasReviews;
    use HasSelections;
    use HasLanguage;
    use HasTagsAndGenres;
    use HasBookType;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
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

    protected $with = [
        'language',
        'authors',
        'serie',
        'media',
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

    public function getMediaPrimaryAttribute(): ?Media
    {
        return $this->getFirstMedia(MediaDiskEnum::cover->value);
    }

    /**
     * Manage files with spatie/laravel-medialibrary.
     *
     * @return MediaExtended[]|null[]
     */
    public function getFilesAttribute()
    {
        $files = [];
        foreach (BookFormatEnum::toValues() as $format) {
            $media = $this->getMedia($format)
                ->first(null, MediaExtended::class)
            ;
            $files[$format] = is_string($media) ? null : $media;
        }

        // @phpstan-ignore-next-line
        return $files;
    }

    /**
     * Manage files with spatie/laravel-medialibrary.
     *
     * @return MediaExtended[]
     */
    public function getFilesType(BookFormatEnum $format)
    {
        $files = [];
        foreach (BookFormatEnum::toValues() as $format) {
            $media = $this->getMedia($format)
                ->first(null, MediaExtended::class)
            ;
            $files[$format] = is_string($media) ? null : $media;
        }

        // @phpstan-ignore-next-line
        return $files;
    }

    public function getRelatedLinkAttribute(): string
    {
        return route('api.entities.related', [
            'author_slug' => $this->meta_author,
            'book_slug' => $this->slug,
        ]);
    }

    public function getOpdsLinkAttribute(): string
    {
        return route('front.opds.books.show', [
            'version' => '1.2',
            'author' => $this->meta_author,
            'book' => $this->slug,
        ]);
    }

    public function getFileMainAttribute(): DownloadFile
    {
        return current(array_filter(array_reverse($this->files_list)));
    }

    /**
     * @return DownloadFile[]
     */
    public function getFilesListAttribute()
    {
        $list = [];
        $formats = BookFormatEnum::toValues();
        foreach ($formats as $format) {
            $media = null;
            if (null !== $this->files[$format]) {
                $route = route('api.download.book', [
                    'author_slug' => $this->meta_author,
                    'book_slug' => $this->slug,
                    'format' => $format,
                ]);
                /** @var MediaExtended $file */
                $file = $this->files[$format];
                $reader = route('webreader.reader', [
                    'author' => $this->meta_author,
                    $this->getClassName() => $this->slug,
                    'format' => $format,
                ]);
                $media = new DownloadFile(
                    $file->file_name,
                    $file->size_human,
                    $route,
                    $reader,
                    $file->extension,
                );
            }
            $list[$format] = $media;
        }

        return $list;
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
            $serie = $this->serie->slug_sort.' '.$volume;
            $serie = Str::slug($serie).'_';
        }
        $title = Str::slug($this->slug_sort);

        return "{$serie}{$title}";
    }

    public function getIsbnAttribute(): ?string
    {
        return $this->isbn13 ?? $this->isbn10;
    }

    public function scopeWhereSerieTitleIs(Builder $query, $title): Builder
    {
        return $query
            ->whereRelation('serie', 'title', '=', $title)
        ;
    }

    public function scopeWhereIsbnIs(Builder $query, $isbn): Builder
    {
        $query->where('isbn13', 'LIKE', "%{$isbn}%");
        $query->orWhere('isbn10', 'LIKE', "%{$isbn}%");

        return $query;
    }

    public function scopeWhereIsDisabled(Builder $query, $is_disabled): Builder
    {
        return $query->where('is_disabled', '=', $is_disabled);
    }

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
            'picture' => $this->cover_thumbnail,
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

    public function updateSlug()
    {
        $serie_title = $this->serie ? $this->serie->title : '';

        $this->slug = ParserEngine::generateSlug($this->title, $this->type->value, $this->language_slug);
        $this->slug_sort = ParserEngine::generateSortSerie($this->title, $serie_title, $this->volume, $this->language_slug);
        $this->save();
    }
}
