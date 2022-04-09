<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Application extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public $table = 'cms_applications';

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
