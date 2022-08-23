<?php

namespace App\Models;

use App\Enums\PostTypeEnum;
use App\Traits\HasSEO;
use App\Traits\HasShowLive;
use App\Traits\HasShowRoute;
use App\Traits\HasSlug;
use App\Traits\Mediable;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use HasSlug;
    use HasShowLive;
    use HasSEO;
    use Mediable;
    use HasShowRoute;
    use Publishable;
    use Searchable;

    public const DEFAULT_PER_PAGE = 15;

    protected $fillable = [
        'title',
        'subtitle',
        'summary',
        'body',

        'youtube_id',
        'cta',
        'is_pinned',
        'type',

        'image',
        'image_extra',
    ];

    protected $slug_with = 'title';
    protected $meta_title_from = 'title';
    protected $meta_description_from = 'summary';

    protected $casts = [
        'is_pinned' => 'boolean',
        'type' => PostTypeEnum::class,
    ];

    public function getRelatedAttribute()
    {
        $current = Post::where('slug', '=', $this->slug)->first();
        return Post::whereHas('tags', fn (Builder $q) => $q->whereIn('name', $current->tags->pluck('name')))
            ->where('id', '!=', $current->id) // So you won't fetch same post
            ->get()
        ;
    }

    public function getRecentAttribute()
    {
        return Post::published()
            ->where('slug', '!=', $this->slug)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get()
        ;
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(TeamMember::class);
    }

    public function searchableAs()
    {
        $app_name = config('app.name');

        return "{$app_name}_posts";
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'summary' => $this->summary,
            'body' => $this->body,
            'image' => $this->getMediable(),
            'published_at' => $this->published_at,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];
    }
}
