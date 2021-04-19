<?php

namespace App\Models;

use App\Utils\BookshelvesTools;
use Auth;
use App\Utils\Tools;
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

        // $this->addMediaConversion('basic')
        //     ->crop(Manipulations::CROP_TOP, $formatBasic['width'], $formatBasic['height'])
        //     ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('thumbnail')
            ->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('open_graph')
            ->crop(Manipulations::CROP_CENTER, $formatStandard['width'], $formatStandard['height'])
            ->format('jpg');
    }

    // public function getImageAttribute(): string | null
    // {
    //     return $this->getMedia('series')->first()?->getUrl('basic');
    // }

    public function getImageThumbnailAttribute(): string | null
    {
        return $this->getMedia('series')->first()?->getUrl('thumbnail');
    }

    public function getImageOpenGraphAttribute(): string | null
    {
        return $this->getMedia('series')->first()?->getUrl('open_graph');
    }

    public function getShowLinkAttribute(): string
    {
        $route = route('api.series.show', [
            'author' => $this->author->slug,
            'serie'  => $this->slug,
        ]);

        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.serie', [
            'author' => $this->author->slug,
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
     * @return Author
     */
    public function getAuthorAttribute(): Author
    {
        return $this->morphToMany(Author::class, 'authorable')->first();
    }
}
