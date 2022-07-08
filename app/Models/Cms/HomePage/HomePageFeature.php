<?php

namespace App\Models\Cms\HomePage;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class HomePageFeature extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    public $translatable = [
        'title',
        'text',
    ];

    protected $table = 'cms_home_page_features';

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
        return $this->belongsTo(HomePage::class, 'home_page_id');
    }
}
