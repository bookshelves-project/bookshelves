<?php

namespace App\Models;

use Auth;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
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

    /** @mixin \Spatie\Image\Manipulations */
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

    public function getImageThumbnailAttribute(): string | null
    {
        return $this->getMedia('books')->first()?->getUrl('thumbnail');
    }

    public function getImageOpenGraphAttribute(): string | null
    {
        return $this->getMedia('books')->first()?->getUrl('open_graph');
    }

    public function getImageOriginalAttribute(): string | null
    {
        return $this->getMedia('books')->first()?->getUrl();
    }

    public function getEpubAttribute(): string | null
    {
        return $this->getMedia('epubs')->first()?->getUrl();
    }

    public function getShowLinkAttribute(): string
    {
        $route = route('api.books.show', [
            'author' => $this->author->slug,
            'book'   => $this->slug,
        ]);

        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.book', [
            'author' => $this->author->slug,
            'book'   => $this->slug,
        ]);

        return $route;
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

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
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
}
