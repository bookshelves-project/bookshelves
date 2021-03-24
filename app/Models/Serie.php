<?php

namespace App\Models;

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

/**
 * App\Models\Serie.
 *
 * @property int                                                                                                                           $id
 * @property string|null                                                                                                                   $title
 * @property string|null                                                                                                                   $title_sort
 * @property string|null                                                                                                                   $slug
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[]                                                                   $books
 * @property int|null                                                                                                                      $books_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[]                                                                $comments
 * @property int|null                                                                                                                      $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\User[]                                                                   $favorites
 * @property int|null                                                                                                                      $favorites_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property int|null                                                                                                                      $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitleSort($value)
 * @mixin \Eloquent
 *
 * @property string|null               $language_slug
 * @property string                    $download_link
 * @property string|null               $image
 * @property string                    $show_link
 * @property \App\Models\Language|null $language
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguageSlug($value)
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property int|null                                                      $authors_count
 * @property \App\Models\Author                                            $author
 * @property string|null                                                   $image_thumbnail
 */
class Serie extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'title_sort',
        'slug',
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
            ->crop(Manipulations::CROP_TOP, $formatStandard['width'], $formatStandard['height'])
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

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_number');
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
