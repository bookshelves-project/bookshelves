<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
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

    protected $table = 'cms_home_pages';

    protected $fillable = [
        'hero_title',
        'hero_text',
        'statistics_eyebrow',
        'statistics_title',
        'statistics_text',
        'logos_title',
        'features_title',
        'features_text',
        'display_statistics',
        'display_logos',
        'display_features',
        'display_latest',
        'display_selection',
        'display_highlights',
    ];

    protected $casts = [
        'display_statistics' => 'boolean',
        'display_logos' => 'boolean',
        'display_features' => 'boolean',
        'display_latest' => 'boolean',
        'display_selection' => 'boolean',
        'display_highlights' => 'boolean',
    ];

    protected $with = [
        'statistics',
        'logos',
        'features',
    ];

    public function getHeroPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_hero');
    }

    public function statistics()
    {
        return $this->hasMany(HomePageStatistic::class, 'home_page_id');
    }

    public function logos()
    {
        return $this->hasMany(HomePageLogo::class, 'home_page_id');
    }

    public function features()
    {
        return $this->hasMany(HomePageFeature::class, 'home_page_id');
    }

    public function highlights()
    {
        return $this->hasMany(HomePageHighlight::class, 'home_page_id');
    }
}
