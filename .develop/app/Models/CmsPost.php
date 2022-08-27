<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use App\Models\Traits\HasPublishStatus;
use App\Services\MarkdownToHtmlService;
use App\Services\MediaService;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

/**
 * @property null|\App\Models\PostCategory $category
 */
class CmsPost extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTags;
    use HasPublishStatus;
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
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status' => PostStatusEnum::class,
        'pin' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $slug_with = 'title';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured-image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
        ;

        $this->addMediaCollection('post-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
        ;
    }

    public function getCoverAttribute(): string
    {
        return MediaService::getFullUrl($this, 'featured-image');
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.posts.show', [
            'post_slug' => $this->slug,
        ]);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function searchableAs()
    {
        $app = config('bookshelves.slug');

        return "{$app}_post";
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function (CmsPost $post) {
            $post->body = MarkdownToHtmlService::setHeadings($post);
        });
    }
}
