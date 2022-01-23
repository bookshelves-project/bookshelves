<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Cms\CmsHomePageHighlight.
 *
 * @property int                                                                                                                           $id
 * @property null|array                                                                                                                    $title
 * @property null|string                                                                                                                   $slug
 * @property null|array                                                                                                                    $text
 * @property null|array                                                                                                                    $cta_text
 * @property null|string                                                                                                                   $cta_link
 * @property null|array                                                                                                                    $quote_text
 * @property null|array                                                                                                                    $quote_author
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property null|string                                                                                                                   $picture
 * @property array                                                                                                                         $translations
 * @property \App\Models\Cms\CmsHomePage                                                                                                   $homePage
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereCtaLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereCtaText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereQuoteAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereQuoteText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property null|int $cms_home_page_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageHighlight whereCmsHomePageId($value)
 *
 * @property null|string $icon
 */
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
        return $this->belongsTo(CmsHomePage::class, 'cms_home_page_id');
    }
}
