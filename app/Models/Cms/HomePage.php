<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class HomePage extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = [
        'hero_title',
        'hero_text',
        'statistics_eyebrow',
        'statistics_title',
        'statistics_text',
        'logos_title',
        'features_title',
        'features_text',
    ];
    protected $table = 'cms_home_page';
    protected $fillable = [
        'hero_title',
        'hero_text',
        'statistics_eyebrow',
        'statistics_title',
        'statistics_text',
        'statistics',
        'logos_title',
        'logos',
        'features_title',
        'features_text',
        'features',
        'display_statistics',
        'display_logos',
        'display_features',
        'display_latest',
        'display_selection',
    ];

    protected $casts = [
        'statistics' => 'array',
        'logos' => 'array',
        'features' => 'array',
        'display_statistics' => 'boolean',
        'display_logos' => 'boolean',
        'display_features' => 'boolean',
        'display_latest' => 'boolean',
        'display_selection' => 'boolean',
    ];

    public function getHeroPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_hero');
    }

    public function getLogosMediaAttribute(): array
    {
        $media = $this->getMedia('cms_logos');
        $gallery = [];
        foreach ($media as $picture) {
            array_push($gallery, $picture->getFullUrl());
        }

        return $gallery;
    }

    public function getStatisticsAttribute($value): Collection
    {
        $statistics = collect([]);
        foreach (json_decode($value) as $key => $statistic) {
            $statistic = new HomePageStatistic((array) $statistic);
            $statistics->add($statistic);
        }

        return $statistics;
    }
}
