<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

/**
 * App\Models\Post.
 *
 * @property int                                                                              $id
 * @property null|int                                                                         $category_id
 * @property string                                                                           $title
 * @property PostStatusEnum                                                                   $status
 * @property null|string                                                                      $summary
 * @property null|string                                                                      $body
 * @property null|Carbon                                                                      $published_at
 * @property bool                                                                             $pin
 * @property bool                                                                             $promote
 * @property string                                                                           $slug
 * @property null|string                                                                      $meta_title
 * @property null|string                                                                      $meta_description
 * @property null|Carbon                                                                      $created_at
 * @property null|Carbon                                                                      $updated_at
 * @property null|PostCategory                                                                $category
 * @property Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection $media
 * @property null|int                                                                         $media_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                      $tags
 * @property null|int                                                                         $tags_count
 * @property null|int                                                                         $user_id
 * @property null|\App\Models\User                                                            $user
 *
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereBody($value)
 * @method static Builder|Post whereCategoryId($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereMetaDescription($value)
 * @method static Builder|Post whereMetaTitle($value)
 * @method static Builder|Post wherePin($value)
 * @method static Builder|Post wherePromote($value)
 * @method static Builder|Post wherePublishedAt($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereStatus($value)
 * @method static Builder|Post whereSummary($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post draft()
 * @method static Builder|Post published()
 * @method static Builder|Post scheduled()
 * @method static Builder|Post publishedBetween($startDate, $endDate)
 * @method static Builder|Post withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static Builder|Post withAllTagsOfAnyType($tags)
 * @method static Builder|Post withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static Builder|Post whereUserId($value)
 * @method static Builder|Post withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 */
class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'category_id',
        'user_id',
        'summary',
        'body',
        'published_at',
        'pin',
        'promote',
        'meta_title',
        'meta_description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => PostStatusEnum::class,
        'pin' => 'boolean',
        'promote' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured-image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
        ;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
        ;
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDraft(Builder $query)
    {
        return $query->whereStatus(PostStatusEnum::draft());
    }

    public function scopeScheduled(Builder $query)
    {
        return $query->whereStatus(PostStatusEnum::scheduled());
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereStatus(PostStatusEnum::published());
    }

    public function scopePublishedBetween(Builder $query, $startDate, $endDate)
    {
        return $query
            ->whereBetween('published_at', [Carbon::parse($startDate), Carbon::parse($endDate)])
        ;
    }
}
