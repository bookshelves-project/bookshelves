<?php

namespace App\Models\Cms\HomePage;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class HomePageHighlight extends Model implements HasMedia
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

    protected $table = 'cms_home_page_highlights';

    protected $fillable = [
        'title',
        'text',
        'cta_text',
        'cta_link',
        'quote_text',
        'quote_author',
    ];

    protected $casts = [
        'cta_link' => 'array',
    ];

    public function getIconAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_highlights_icons');
    }

    public function getPictureAttribute(): string|null
    {
        return $this->getFirstMediaUrl('cms_highlights');
    }

    public function homePage()
    {
        return $this->belongsTo(HomePage::class, 'home_page_id');
    }
}
