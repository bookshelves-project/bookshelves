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
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

/**
 * @property null|\App\Models\PostCategory $category
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
