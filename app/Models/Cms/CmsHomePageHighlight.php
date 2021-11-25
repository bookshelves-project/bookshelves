<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class CmsHomePageHighlight extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    public $translatable = [
        'title',
        'text',
        'cta_text',
        'quote_text',
        'quote_author',
    ];
    protected $fillable = [
        'title',
        'text',
        'cta_text',
        'cta_link',
        'quote_text',
        'quote_author',
    ];

    public function getPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_highlights');
    }

    public function homePage()
    {
        return $this->belongsTo(CmsHomePage::class, 'cms_home_page_id');
    }
}
