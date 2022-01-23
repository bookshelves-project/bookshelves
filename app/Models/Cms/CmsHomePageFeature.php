<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Cms\CmsHomePageFeature.
 *
 * @property int                                                                                                                           $id
 * @property null|array                                                                                                                    $title
 * @property null|string                                                                                                                   $slug
 * @property null|string                                                                                                                   $link
 * @property null|array                                                                                                                    $text
 * @property null|int                                                                                                                      $cms_home_page_id
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property null|string                                                                                                                   $picture
 * @property array                                                                                                                         $translations
 * @property null|\App\Models\Cms\CmsHomePage                                                                                              $homePage
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereCmsHomePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageFeature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CmsHomePageFeature extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    public $translatable = [
        'title',
        'text',
    ];
    protected $fillable = [
        'title',
        'slug',
        'link',
        'text',
    ];
    protected $casts = [
        'link' => 'array',
    ];

    public function getPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_features');
    }

    public function homePage()
    {
        return $this->belongsTo(CmsHomePage::class, 'cms_home_page_id');
    }
}
