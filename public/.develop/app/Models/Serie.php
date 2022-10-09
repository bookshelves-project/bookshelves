<?php

namespace App\Models;

use App\Engines\ParserEngine;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Traits\HasAuthors;
use App\Models\Traits\HasBooksCollection;
use App\Models\Traits\HasBookType;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasLanguage;
use App\Models\Traits\HasReviews;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasTagsAndGenres;
use App\Models\Traits\Haswikipedia_item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * @property null|int $books_count
 */
class Serie extends Model implements HasMedia
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
    use Haswikipedia_item;
    use HasBooksCollection;
    use HasTranslations;

    public $translatable = [
        'description',
    ];

    protected $fillable = [
        'title',
        'slug_sort',
        'slug',
        'type',
        'description',
        'link',
    ];

    protected $casts = [
        'type' => BookTypeEnum::class,
    ];

    protected $with = [
        'language',
        'authors',
        'media',
    ];

    protected $withCount = [
        'books',
    ];

    public function getMediaPrimaryAttribute(): ?Media
    {
        return $this->getFirstMedia(MediaDiskEnum::cover->value);
    }

    public function getOpdsLinkAttribute(): string
    {
        return route('front.opds.series.show', [
            'version' => '1.2',
            'author' => $this->meta_author,
            'serie' => $this->slug,
        ]);
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
    }

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

    public function searchableAs()
    {
        $app = config('bookshelves.slug');

        return "{$app}_series";
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'picture' => $this->cover_thumbnail,
            'author' => $this->authors_names,
            'description' => $this->description,
            'tags' => $this->tags_string,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get Books into Serie, by volume order.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('volume');
    }

    /**
     * Get available Books into Serie, by volume order.
     */
    public function booksAvailable(): HasMany
    {
        return $this->hasMany(Book::class)
            ->where('is_disabled', false)
            ->orderBy('volume')
        ;
    }

    public function updateSlug()
    {
        $this->slug = ParserEngine::generateSlug($this->title, $this->type->value, $this->language_slug);
        $this->slug_sort = ParserEngine::generateSortTitle($this->title, $this->language_slug);
        $this->save();
    }
}
