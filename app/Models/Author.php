<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use App\Models\Traits\HasBooksCollection;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasReviews;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasWikipediaItem;
use App\Utils\BookshelvesTools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

/**
 * @property null|int $books_count
 * @property null|int $series_count
 */
class Author extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use HasClassName;
    use HasCovers;
    use HasFavorites;
    use HasReviews;
    use HasSelections;
    use Searchable;
    use HasWikipediaItem;
    use HasSlug;
    use HasBooksCollection;

    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'slug',
        'role',
        'description',
        'link',
        'note',
    ];

    protected $with = [
        'media',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['lastname', 'firstname'])
            ->saveSlugsTo('slug')
        ;
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.authors.show', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getOpdsLinkAttribute(): string
    {
        return route('front.opds.authors.show', [
            'version' => 'v1.2',
            'author' => $this->slug,
        ]);
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
    }

    public function getBooksLinkAttribute(): string
    {
        return route('api.authors.show.books', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getSeriesLinkAttribute(): string
    {
        return route('api.authors.show.series', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getDownloadLinkFormat(string $format): string
    {
        $format = BookFormatEnum::from($format)->value;

        return route('api.download.author', [
            'author_slug' => $this->slug,
            'format' => $format,
        ]);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'picture' => $this->cover_thumbnail,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function getFirstCharAttribute(): string
    {
        return strtolower($this->lastname[0]);
    }

    /**
     * Get all of the books that are assigned this author.
     */
    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')
            ->orderBy('slug_sort')
            ->orderBy('volume')
        ;
    }

    /**
     * Get all available books that are assigned this author.
     */
    public function booksAvailable(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')
            ->where('disabled', false)
            ->orderBy('slug_sort')
            ->orderBy('volume')
        ;
    }

    /**
     * Get books without series that are assigned this author.
     */
    public function booksAvailableStandalone(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')
            ->where('disabled', false)
            ->whereDoesntHave('serie')
            ->orderBy('slug_sort')
            ->orderBy('volume')
        ;
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'authorable')
            ->orderBy('slug_sort')
            ->withCount('books')
        ;
    }
}
