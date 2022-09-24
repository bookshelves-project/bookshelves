<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use App\Models\Traits\HasPublishStatus;
use App\Services\MarkdownToHtmlService;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use HasPublishStatus;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status' => PostStatusEnum::class,
        'published_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured-image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
        ;

        $this->addMediaCollection('page-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
        ;
    }

    public function getCoverAttribute(): string
    {
        return MediaService::getFullUrl($this, 'featured-image');
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.pages.show', [
            'page_slug' => $this->slug,
        ]);
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function (Page $page) {
            $page->body = MarkdownToHtmlService::setHeadings($page);
        });
    }
}
