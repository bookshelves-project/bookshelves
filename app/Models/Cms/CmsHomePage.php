<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Cms\CmsHomePage.
 *
 * @property int                                                                                                                           $id
 * @property null|array                                                                                                                    $hero_title
 * @property null|array                                                                                                                    $hero_text
 * @property null|array                                                                                                                    $statistics_eyebrow
 * @property null|array                                                                                                                    $statistics_title
 * @property null|array                                                                                                                    $statistics_text
 * @property null|array                                                                                                                    $logos_title
 * @property null|array                                                                                                                    $features_title
 * @property null|array                                                                                                                    $features_text
 * @property null|bool                                                                                                                     $display_statistics
 * @property null|bool                                                                                                                     $display_logos
 * @property null|bool                                                                                                                     $display_features
 * @property null|bool                                                                                                                     $display_latest
 * @property null|bool                                                                                                                     $display_selection
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property \App\Models\Cms\CmsHomePageFeature[]|\Illuminate\Database\Eloquent\Collection                                                 $features
 * @property null|int                                                                                                                      $features_count
 * @property null|string                                                                                                                   $hero_picture
 * @property array                                                                                                                         $translations
 * @property \App\Models\Cms\CmsHomePageLogo[]|\Illuminate\Database\Eloquent\Collection                                                    $logos
 * @property null|int                                                                                                                      $logos_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property \App\Models\Cms\CmsHomePageStatistic[]|\Illuminate\Database\Eloquent\Collection                                               $statistics
 * @property null|int                                                                                                                      $statistics_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereDisplayFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereDisplayLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereDisplayLogos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereDisplaySelection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereDisplayStatistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereFeaturesText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereFeaturesTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereHeroText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereHeroTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereLogosTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereStatisticsEyebrow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereStatisticsText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereStatisticsTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property null|bool                                                                       $display_highlights
 * @property \App\Models\Cms\CmsHomePageHighlight[]|\Illuminate\Database\Eloquent\Collection $highlights
 * @property null|int                                                                        $highlights_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePage whereDisplayHighlights($value)
 */
class CmsHomePage extends Model implements HasMedia
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
        return $this->hasMany(CmsHomePageStatistic::class, 'cms_home_page_id');
    }

    public function logos()
    {
        return $this->hasMany(CmsHomePageLogo::class, 'cms_home_page_id');
    }

    public function features()
    {
        return $this->hasMany(CmsHomePageFeature::class, 'cms_home_page_id');
    }

    public function highlights()
    {
        return $this->hasMany(CmsHomePageHighlight::class, 'cms_home_page_id');
    }
}
