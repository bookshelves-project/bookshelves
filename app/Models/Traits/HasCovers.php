<?php

namespace App\Models\Traits;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Manage covers with conversions with `spatie/laravel-medialibrary`
 */
trait HasCovers
{
    use InteractsWithMedia;
    
    /** @mixin \Spatie\Cover\Manipulations */
    public function registerMediaConversions(Media $media = null): void
    {
        $formatThumbnail = config('image.covers.thumbnail');
        $formatStandard = config('image.covers.og');
        $formatSimple = config('image.covers.simple');

        // $this->addMediaConversion('basic')
        //     ->crop(Manipulations::CROP_TOP, $formatBasic['width'], $formatBasic['height'])
        //     ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('thumbnail')
            ->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('og')
            ->crop(Manipulations::CROP_CENTER, $formatStandard['width'], $formatStandard['height'])
            ->format('jpg');

        $this->addMediaConversion('simple')
            ->crop(Manipulations::CROP_CENTER, $formatSimple['width'], $formatSimple['height'])
            ->format('jpg');
    }

    /**
     * Get cover thumbnail with `spatie/laravel-medialibrary`
     * With config/bookshelves define format
     */
    public function getCoverThumbnailAttribute(): string | null
    {
        // return BookshelvesTools::convertPicture($this, $this->meta_author.'_'.$this->slug);
        return $this->getFirstMediaUrl($this->getClassName(true), 'thumbnail');
    }

    /**
     * Get cover OpenGraph with `spatie/laravel-medialibrary`
     * With JPG format for social
     */
    public function getCoverOgAttribute(): string | null
    {
        // return BookshelvesTools::convertPicture($this, $this->meta_author.'_'.$this->slug, 'og');
        return $this->getFirstMediaUrl($this->getClassName(true), 'og');
    }

    /**
     * Get cover simple with `spatie/laravel-medialibrary`
     * With JPG format for Catalog
     */
    public function getCoverSimpleAttribute(): string | null
    {
        // return BookshelvesTools::convertPicture($this, $this->meta_author.'_'.$this->slug, 'simple');
        return $this->getFirstMediaUrl($this->getClassName(true), 'simple');
    }

    /**
     * Get cover original with `spatie/laravel-medialibrary`
     * With config/bookshelves define format
     */
    public function getCoverOriginalAttribute(): string | null
    {
        return $this->getFirstMediaUrl($this->getClassName(true));
    }

    /**
     * Get cover main color with `spatie/laravel-medialibrary`
     * Use for placeholder during cover loading
     */
    public function getCoverColorAttribute(): string | null
    {
        /** @var Media $media */
        $media = $this->getFirstMedia($this->getClassName(true));

        if ($media) {
            $color = $media->getCustomProperty('color');

            return "#$color";
        }

        return null;
    }
}
