<?php

namespace App\Models;

use Auth;
use Spatie\Tags\HasTags;
use App\Utils\BookshelvesTools;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Serie extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;

    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'description',
        'link',
    ];

    protected $with = [
        'language',
    ];

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
        return $this->getFirstMediaUrl('series');
    }

    public function getImageColorAttribute(): string | null
    {
        /** @var Media $media */
        $media = $this->getFirstMedia('series');

        if ($media) {
            $color = $media->getCustomProperty('color');

            return "#$color";
        }

        return null;
    }

    public function getShowLinkAttribute(): string
    {
        if ($this->meta_author && $this->slug) {
            $route = route('api.series.show', [
                'author' => $this->meta_author,
                'serie'  => $this->slug,
            ]);

            return $route;
        }

        return '';
    }

    public function getShowLinkOpdsAttribute(): string
    {
        $route = route('opds.series.show', [
            'version' => 'v1.2',
            'author'  => $this->meta_author,
            'serie'   => $this->slug,
        ]);

        return $route;
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
    }

    public function getShowBooksLinkAttribute(): string
    {
        $route = route('api.series.show.books', [
            'author' => $this->meta_author,
            'serie'  => $this->slug,
        ]);

        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.serie', [
            'author' => $this->meta_author,
            'serie'  => $this->slug,
        ]);

        return $route;
    }

    public function getSizeAttribute(): string
    {
        $size = [];
        $serie = Serie::whereSlug($this->slug)->with('books.media')->first();
        $books = $serie->books;
        foreach ($books as $key => $book) {
            array_push($size, $book->getMedia('epubs')->first()?->size);
        }
        $size = array_sum($size);
        $size = BookshelvesTools::humanFilesize($size);

        return $size;
    }

    public function getTagsListAttribute()
    {
        return $this->tags()->whereType('tag')->get();
    }

    public function getGenresListAttribute()
    {
        return $this->tags()->whereType('genre')->get();
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('volume');
    }

    public function getIsFavoriteAttribute(): bool
    {
        $is_favorite = false;
        if (Auth::check()) {
            $entity = Serie::whereSlug($this->slug)->first();

            $checkIfFavorite = Serie::find($entity->id)->favorites;
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

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function getMetaAuthorAttribute(): string | null
    {
        $author = $this->authors->first();

        return $author->slug;
    }

    /**
     * Authors MorphToMany.
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function selections(): MorphToMany
    {
        return $this->morphToMany(User::class, 'selectionable');
    }
}
