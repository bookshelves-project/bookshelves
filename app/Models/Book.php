<?php

namespace App\Models;

use Auth;
use Spatie\Tags\HasTags;
use Illuminate\Support\Str;
use App\Utils\BookshelvesTools;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Book extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'contributor',
        'description',
        'date',
        'rights',
        'volume',
        'page_count',
        'maturity_rating',
    ];

    protected $with = [
        'language',
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
        return $this->where('slug', $value)->with('media')->firstOrFail();
    }

    public function getImageThumbnailAttribute(): string | null
    {
        return BookshelvesTools::convertPicture($this, $this->meta_author.'_'.$this->slug);
    }

    public function getImageogAttribute(): string | null
    {
        return BookshelvesTools::convertPicture($this, $this->meta_author.'_'.$this->slug, 'og');
    }

    public function getImageSimpleAttribute(): string | null
    {
        return BookshelvesTools::convertPicture($this, $this->meta_author.'_'.$this->slug, 'simple');
    }

    public function getImageOriginalAttribute(): string | null
    {
        return $this->getFirstMediaUrl('books');
    }

    public function getImageColorAttribute(): string | null
    {
        /** @var Media $media */
        $media = $this->getFirstMedia('books');

        if ($media) {
            $color = $media->getCustomProperty('color');

            return "#$color";
        }

        return null;
    }

    public function getEpubAttribute(): string | null
    {
        return $this->getFirstMediaUrl('epubs');
    }

    public function getAuthorsNamesAttribute(): string
    {
        $authors = [];
        foreach ($this->authors as $key => $author) {
            array_push($authors, $author->name);
        }

        return implode(', ', $authors);
    }

    public function getShowLinkAttribute(): string
    {
        if ($this->meta_author && $this->slug) {
            $route = route('api.books.show', [
                'author' => $this->meta_author,
                'book'   => $this->slug,
            ]);

            return $route;
        }

        return '';
    }

    public function getShowLinkOpdsAttribute(): string
    {
        $route = route('opds.books.show', [
            'version' => 'v1.2',
            'author'  => $this->meta_author,
            'book'    => $this->slug,
        ]);

        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.book', [
            'author' => $this->meta_author,
            'book'   => $this->slug,
        ]);

        return $route;
    }

    public function getWebreaderLinkAttribute(): string
    {
        if ($this->meta_author && $this->slug) {
            $route = route('webreader.cover', [
                'author' => $this->meta_author,
                'book'   => $this->slug,
            ]);

            return $route;
        }

        return '';
    }

    public function getIsFavoriteAttribute(): bool
    {
        $is_favorite = false;
        if (Auth::check()) {
            $entity = Book::whereSlug($this->slug)->first();

            $checkIfFavorite = Book::find($entity->id)->favorites;
            if (! sizeof($checkIfFavorite) < 1) {
                $is_favorite = true;
            }
        }

        return $is_favorite;
    }

    public function getSortNameAttribute(): string
    {
        $serie = null;
        if ($this->serie) {
            $volume = strlen($this->volume) < 2 ? '0'.$this->volume : $this->volume;
            $serie = $this->serie?->title_sort.' '.$volume;
            $serie = Str::slug($serie).'_';
        }
        $title = Str::slug($this->title_sort);

        return "$serie$title";
    }

    public function getTagsListAttribute()
    {
        return $this->tags()->whereType('tag')->get();
    }

    public function getGenresListAttribute()
    {
        return $this->tags()->whereType('genre')->get();
    }

    /**
     * Authors MorphToMany.
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function getMetaAuthorAttribute(): string | null
    {
        $author = $this->authors->first();

        return $author->slug;
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function identifier(): BelongsTo
    {
        return $this->belongsTo(Identifier::class);
    }

    public function googleBook(): BelongsTo
    {
        return $this->belongsTo(GoogleBook::class);
    }

    public function favorites(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function selections(): MorphToMany
    {
        return $this->morphToMany(User::class, 'selectionable')->withTimestamps();
    }
}
