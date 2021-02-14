<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Author.
 *
 * @property int                                                                                                                           $id
 * @property string|null                                                                                                                   $slug
 * @property string|null                                                                                                                   $lastname
 * @property string|null                                                                                                                   $firstname
 * @property string|null                                                                                                                   $name
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[]                                                                   $books
 * @property int|null                                                                                                                      $books_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[]                                                                $comments
 * @property int|null                                                                                                                      $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\User[]                                                                   $favorites
 * @property int|null                                                                                                                      $favorites_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property int|null                                                                                                                      $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereSlug($value)
 * @mixin \Eloquent
 * @property-read string $download_link
 * @property-read string|null $image
 * @property-read string $show_link
 */
class Author extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'slug',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $formatBasic = config('image.thumbnails.book_cover');
        $formatThumbnail = config('image.thumbnails.book_thumbnail');

        $this->addMediaConversion('basic')
            ->fit(Manipulations::FIT_CROP, $formatBasic['width'], $formatBasic['height'])
            ->sharpen(10);

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->sharpen(10);
    }

    public function getImageAttribute(): string|null
    {
        return $this->getMedia('authors')?->first()?->getUrl('basic');
    }

    public function getShowLinkAttribute(): string
    {
        return config('app.url')."/api/authors/$this->slug";
    }

    public function getDownloadLinkAttribute(): string
    {
        return config('app.url')."/api/download/author/$this->slug";
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->orderBy('serie_id')->orderBy('serie_number');
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
