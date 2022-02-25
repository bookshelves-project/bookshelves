<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use App\Utils\BookshelvesTools;
use App\Models\Traits\HasCovers;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasWikipediaItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
    use HasComments;
    use HasSelections;
    use Searchable;
    use HasWikipediaItem;
    use HasSlug;

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
        return route('api.v1.authors.show', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getShowLinkOpdsAttribute(): string
    {
        return route('front.opds.authors.show', [
            'version_slug' => 'v1.2',
            'author_slug' => $this->slug,
        ]);
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
    }

    public function getShowBooksLinkAttribute(): string
    {
        return route('api.v1.authors.show.books', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getShowSeriesLinkAttribute(): string
    {
        return route('api.v1.authors.show.series', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getDownloadLinkAttribute(): string
    {
        return route('api.v1.authors.download', [
            'author_slug' => $this->slug,
        ]);
    }

    public function getSizeAttribute(): string
    {
        $author = Author::whereSlug($this->slug)
            ->with('books.media')
            ->first()
        ;
        $size = 0;
        foreach ($author->books as $book) {
            $size += $book->epub->size;
        }

        return BookshelvesTools::humanFilesize($size);
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

    public function wikipediaItem(): BelongsTo
    {
        return $this->belongsTo(WikipediaItem::class);
    }
}
