<?php

namespace App\Models;

use App\Enums\PostCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kiwilan\Steward\Traits\HasSeo;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Publishable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use Publishable;
    use InteractsWithMedia;
    use HasSeo;
    use Searchable;

    protected $slug_with = 'title';
    protected $meta_title_from = 'title';

    protected $fillable = [
        'title',
        'summary',
        'body',
        'is_pinned',
        'category',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'category' => PostCategoryEnum::class,
    ];

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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scout.
     */
    public function searchableAs()
    {
        $app = config('bookshelves.slug');

        return "{$app}_post";
    }
}
