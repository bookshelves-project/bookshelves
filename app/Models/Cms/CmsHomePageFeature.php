<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

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

    public function getPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_features');
    }

    public function homePage()
    {
        return $this->belongsTo(CmsHomePage::class, 'cms_home_page_id');
    }
}
