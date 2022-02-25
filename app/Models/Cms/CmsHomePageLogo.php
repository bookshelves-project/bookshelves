<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Cms\CmsHomePageLogo.
 *
 * @property int                                                                                                                           $id
 * @property null|string                                                                                                                   $label
 * @property null|string                                                                                                                   $slug
 * @property null|string                                                                                                                   $link
 * @property null|int                                                                                                                      $cms_home_page_id
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property null|string                                                                                                                   $picture
 * @property null|\App\Models\Cms\CmsHomePage                                                                                              $homePage
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereCmsHomePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageLogo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CmsHomePageLogo extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'label',
        'slug',
        'link',
    ];

    public function getPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_logos');
    }

    public function homePage()
    {
        return $this->belongsTo(CmsHomePage::class, 'cms_home_page_id');
    }
}
