<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
