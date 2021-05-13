<?php

namespace App\Models;

use Auth;
use App\Utils\BookshelvesTools;
use Spatie\Image\Manipulations;
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

    public $timestamps = false;
    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'description',
        'wikipedia_link',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $formatBasic = config('image.thumbnails.picture_cover');
        $formatThumbnail = config('image.thumbnails.picture_thumbnail');
        $formatStandard = config('image.thumbnails.picture_open_graph');

        $this->addMediaConversion('thumbnail')
            ->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('open_graph')
            ->crop(Manipulations::CROP_CENTER, $formatStandard['width'], $formatStandard['height'])
            ->format('jpg');
    }

    public function getImageThumbnailAttribute(): string | null
    {
        return $this->getFirstMediaUrl('series', 'thumbnail');
    }

    public function getImageOpenGraphAttribute(): string | null
    {
        return $this->getFirstMediaUrl('series', 'open_graph');
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
        if ($this->author?->slug && $this->slug) {
            $route = route('api.series.show', [
                'author' => $this->author?->slug,
                'serie'  => $this->slug,
            ]);

            return $route;
        }

        return '';
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.serie', [
            'author' => $this->author?->slug,
            'serie'  => $this->slug,
        ]);

        return $route;
    }

    public function getSizeAttribute(): string
    {
        $size = [];
        foreach ($this->books as $key => $book) {
            array_push($size, $book->getMedia('epubs')->first()?->size);
        }
        $size = array_sum($size);
        $size = BookshelvesTools::humanFilesize($size);

        return $size;
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

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
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

    /**
     * Authors MorphToMany.
     *
     * @return MorphToMany
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    /**
     * First Author for router.
     *
     * @return Author|null
     */
    public function getAuthorAttribute(): Author | null
    {
        return $this->morphToMany(Author::class, 'authorable')->first();
    }
}
