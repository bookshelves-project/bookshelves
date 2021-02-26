<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitleSort($value)
 * @mixin \Eloquent
 * @property string|null $language_slug
 * @property-read string $download_link
 * @property-read string|null $image
 * @property-read string $show_link
 * @property-read \App\Models\Language|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguageSlug($value)
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
        $formatBasic = config('image.thumbnails.book_cover');
        $formatThumbnail = config('image.thumbnails.book_thumbnail');

        $this->addMediaConversion('basic')
            ->crop(Manipulations::CROP_TOP, $formatBasic['width'], $formatBasic['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('thumbnail')
            ->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));
    }

    public function getImageAttribute(): string|null
    {
        return $this->getMedia('series')->first()?->getUrl('basic');
    }

    public function getImageThumbnailAttribute(): string|null
    {
        return $this->getMedia('series')->first()?->getUrl('thumbnail');
    }

    public function getShowLinkAttribute(): string
    {
        return config('app.url')."/api/series/$this->slug";
    }

    public function getDownloadLinkAttribute(): string
    {
        return config('app.url')."/api/download/serie/$this->slug";
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
     * Authors MorphToMany
        * 
     * @return MorphToMany 
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    /**
     * First Author for router
     * 
     * @return Author 
     */
    public function getAuthorAttribute(): Author
    {
        return $this->morphToMany(Author::class,'authorable')->first();
    }
}
