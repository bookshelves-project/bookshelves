<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Laravel\Scout\Searchable;
use App\Utils\BookshelvesTools;
use App\Models\Traits\HasCovers;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasSelections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        'media'
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed       $value
     * @param string|null $field
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->with('media')->withCount('books')->firstOrFail();
    }

    public function getShowLinkAttribute(): string
    {
        $route = route('api.authors.show', [
            'author' => $this->slug,
        ]);

        return $route;
    }

    public function getShowLinkOpdsAttribute(): string
    {
        $route = route('features.opds.authors.show', [
            'version' => 'v1.2',
            'author'  => $this->slug,
        ]);

        return $route;
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count() . ' books';
    }

    public function getShowBooksLinkAttribute(): string
    {
        $route = route('api.authors.show.books', [
            'author' => $this->slug,
        ]);

        return $route;
    }

    public function getShowSeriesLinkAttribute(): string
    {
        $route = route('api.authors.show.series', [
            'author' => $this->slug,
        ]);

        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.author', [
            'author' => $this->slug,
        ]);

        return $route;
    }

    public function getSizeAttribute(): string
    {
        $size = [];
        $author = Author::whereSlug($this->slug)->with('books.media')->first();
        $books = $author->books;
        foreach ($books as $key => $book) {
            array_push($size, $book->getMedia('epubs')->first()?->size);
        }
        $size = array_sum($size);
        $size = BookshelvesTools::humanFilesize($size);

        return $size;
    }

    public function toSearchableArray()
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'firstname'            => $this->firstname,
            'lastname'             => $this->lastname,
            'description'          => $this->description,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at
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
        return $this->morphedByMany(Book::class, 'authorable')->orderBy('serie_id')->orderBy('volume');
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'authorable')->orderBy('title_sort');
    }
}
