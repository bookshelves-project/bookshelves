<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Book.
 *
 * @property int                                                                                                                           $id
 * @property string                                                                                                                        $title
 * @property string|null                                                                                                                   $title_sort
 * @property string|null                                                                                                                   $slug
 * @property string|null                                                                                                                   $contributor
 * @property string|null                                                                                                                   $description
 * @property string|null                                                                                                                   $date
 * @property string|null                                                                                                                   $rights
 * @property int|null                                                                                                                      $serie_id
 * @property int|null                                                                                                                      $serie_number
 * @property int|null                                                                                                                      $publisher_id
 * @property string|null                                                                                                                   $language_slug
 * @property int|null                                                                                                                      $identifier_id
 * @property \Illuminate\Support\Carbon|null                                                                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                                                                               $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Author[]                                                                 $authors
 * @property int|null                                                                                                                      $authors_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[]                                                                $comments
 * @property int|null                                                                                                                      $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\User[]                                                                   $favorites
 * @property int|null                                                                                                                      $favorites_count
 * @property \App\Models\Author                                                                                                            $author
 * @property \App\Models\Identifier|null                                                                                                   $identifier
 * @property \App\Models\Language|null                                                                                                     $language
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property int|null                                                                                                                      $media_count
 * @property \App\Models\Publisher|null                                                                                                    $publisher
 * @property \App\Models\Serie|null                                                                                                        $serie
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]                                                                    $tags
 * @property int|null                                                                                                                      $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereContributor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIdentifierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereRights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitleSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read string $download_link
 * @property-read string|null $epub
 * @property-read string|null $image
 * @property-read string $show_link
 * @property-read string|null $image_original
 * @property-read string|null $image_thumbnail
 * @property int|null $google_book_id
 * @property int|null $page_count
 * @property string|null $maturity_rating
 * @property-read \App\Models\GoogleBook|null $googleBook
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereGoogleBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereMaturityRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePageCount($value)
 */
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
        'serie_number',
        'page_count',
        'maturity_rating',
    ];

    protected $with = [
        'language',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $formatBasic = config('image.thumbnails.book_cover');
        $formatThumbnail = config('image.thumbnails.book_thumbnail');
        $formatStandard = config('image.thumbnails.book_standard');

        $this->addMediaConversion('basic')
            ->crop(Manipulations::CROP_TOP, $formatBasic['width'], $formatBasic['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('thumbnail')
            ->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('standard')
            ->crop(Manipulations::CROP_TOP, $formatStandard['width'], $formatStandard['height'])
            ->sharpen(10)
            ->format('jpg');
    }

    public function getImageAttribute(): string|null
    {
        return $this->getMedia('books')->first()?->getUrl('basic');
    }

    public function getImageThumbnailAttribute(): string|null
    {
        return $this->getMedia('books')->first()?->getUrl('thumbnail');
    }

    public function getImageStandardAttribute(): string|null
    {
        return $this->getMedia('books')->first()?->getUrl('standard');
    }
    
    public function getImageOriginalAttribute(): string|null
    {
        return $this->getMedia('books')->first()?->getUrl();
    }

    public function getEpubAttribute(): string|null
    {
        return $this->getMedia('books_epubs')->first()?->getUrl();
    }

    public function getShowLinkAttribute(): string
    {
        $route = route('api.books.show', [
            'author' => $this->author->slug,
            'book' => $this->slug
        ]);
        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.book', [
            'author' => $this->author->slug,
            'book' => $this->slug
        ]);
        return $route;
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
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
