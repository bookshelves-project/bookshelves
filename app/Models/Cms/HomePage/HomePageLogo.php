<?php

namespace App\Models\Cms\HomePage;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomePageLogo extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'cms_home_page_logos';
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
        return $this->belongsTo(HomePage::class, 'home_page_id');
    }
}
