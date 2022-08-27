<?php

namespace App\Models;

use App\Enums\CmsPostCategoryEnum;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CmsPost extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use Publishable;
    use InteractsWithMedia;
    use HasSeo;
    use Searchable;

    protected $fillable = [
        'title',
        'summary',
        'body',
        'is_pinned',
        'category',

        'user_id',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'category' => CmsPostCategoryEnum::class,
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
