<?php

namespace App\Models;

use Auth;
use Spatie\Tags\HasTags;
use App\Utils\BookshelvesTools;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Author extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use HasTags;

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

    public function registerMediaConversions(Media $media = null): void
    {
        $formatThumbnail = config('image.pictures.thumbnail');
        $formatStandard = config('image.pictures.open_graph');
        $formatSimple = config('image.pictures.simple');

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('open_graph')
            ->crop(Manipulations::CROP_CENTER, $formatStandard['width'], $formatStandard['height'])
            ->format('jpg');

        $this->addMediaConversion('simple')
            ->crop(Manipulations::CROP_CENTER, $formatSimple['width'], $formatSimple['height'])
            ->format('jpg');
    }

    public function getImageThumbnailAttribute(): string | null
    {
        return $this->getFirstMediaUrl('authors', 'thumbnail');
    }

    public function getImageOpenGraphAttribute(): string | null
    {
        return $this->getFirstMediaUrl('authors', 'open_graph');
    }

    public function getImageSimpleAttribute(): string | null
    {
        return $this->getFirstMediaUrl('authors', 'simple');
    }

    public function getImageColorAttribute(): string | null
    {
        /** @var Media $media */
        $media = $this->getFirstMedia('authors');

        if ($media) {
            $color = $media->getCustomProperty('color');

            return "#$color";
        }

        return null;
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
        $route = route('opds.authors.show', [
            'version' => 'v1.2',
            'author'  => $this->slug,
        ]);

        return $route;
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
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

    public function getIsFavoriteAttribute(): bool
    {
        $is_favorite = false;
        if (Auth::check()) {
            $entity = Author::whereSlug($this->slug)->first();

            $checkIfFavorite = Author::find($entity->id)->favorites;
            if (! sizeof($checkIfFavorite) < 1) {
                $is_favorite = true;
            }
        }

        return $is_favorite;
    }

    public function favorites(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
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
