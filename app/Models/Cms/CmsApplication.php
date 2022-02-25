<?php

namespace App\Models\Cms;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Cms\CmsApplication.
 *
 * @property int                                                                                                                           $id
 * @property string                                                                                                                        $name
 * @property string                                                                                                                        $title_template
 * @property string                                                                                                                        $slug
 * @property null|array                                                                                                                    $meta_title
 * @property null|array                                                                                                                    $meta_description
 * @property null|array                                                                                                                    $meta_author
 * @property null|string                                                                                                                   $meta_twitter_creator
 * @property null|string                                                                                                                   $meta_twitter_site
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property null|string                                                                                                                   $favicon
 * @property null|string                                                                                                                   $icon
 * @property null|string                                                                                                                   $logo
 * @property null|string                                                                                                                   $open_graph
 * @property array                                                                                                                         $translations
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereMetaAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereMetaTwitterCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereMetaTwitterSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereTitleTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsApplication whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CmsApplication extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',
        'meta_author',
    ];

    protected $fillable = [
        'name',
        'title_template',
        'slug',
        'meta_title',
        'meta_description',
        'meta_author',
        'meta_twitter_creator',
        'meta_twitter_site',
    ];

    public function getFaviconAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_application_favicon');
    }

    public function getIconAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_application_icon');
    }

    public function getLogoAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_application_logo');
    }

    public function getOpenGraphAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_application_og');
    }
}
