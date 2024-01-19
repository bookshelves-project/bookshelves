<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\Book;
use App\Models\MediaExtended;
use App\Models\Serie;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Manage cover with conversions with `spatie/laravel-medialibrary`.
 *
 * @property string $cover_standard
 * @property string $cover_thumbnail
 * @property string $cover_social
 * @property string $cover_color
 * @property MediaExtended|Media|null $cover_media
 */
trait HasCovers
{
    use InteractsWithMedia;

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $formatThumbnail = config('bookshelves.image.cover.thumbnail');
        $formatStandard = config('bookshelves.image.cover.standard');
        $formatSocial = config('bookshelves.image.cover.social');

        if (config('bookshelves.image.conversion')) {
            $this->addMediaConversion('thumbnail')
                ->performOnCollections('covers')
                ->fit(Fit::Crop, $formatThumbnail['width'], $formatThumbnail['height'])
                ->sharpen(10)
                ->optimize()
                ->format(config('bookshelves.image.format'));

            $this->addMediaConversion('standard')
                ->performOnCollections('covers')
                ->fit(Fit::Crop, $formatStandard['width'], $formatStandard['height'])
                ->sharpen(10)
                ->optimize()
                ->format(config('bookshelves.image.format'));

            $this->addMediaConversion('social')
                ->performOnCollections('covers')
                ->fit(Fit::Crop, $formatSocial['width'], $formatSocial['height'])
                ->sharpen(10)
                ->optimize()
                ->format('jpg');
        }
    }

    /**
     * Get cover Media with `spatie/laravel-medialibrary`.
     *
     * @return null|Media|MediaExtended
     */
    public function getCoverMediaAttribute()
    {
        return $this->getMedia('covers')->first() ?? null;
    }

    /**
     * Get cover original with `spatie/laravel-medialibrary`
     */
    public function getCoverAttribute(): ?string
    {
        return $this->getCover();
    }

    /**
     * Get cover standard with `spatie/laravel-medialibrary`
     */
    public function getCoverStandardAttribute(): ?string
    {
        return $this->getCover('standard');
    }

    /**
     * Get cover thumbnail with `spatie/laravel-medialibrary`
     */
    public function getCoverThumbnailAttribute(): ?string
    {
        return $this->getCover('thumbnail');
    }

    /**
     * Get cover social with `spatie/laravel-medialibrary`
     */
    public function getCoverSocialAttribute(): ?string
    {
        return $this->getCover('social');
    }

    /**
     * Get cover main color with `spatie/laravel-medialibrary`
     */
    public function getCoverColorAttribute(): ?string
    {
        /** @var ?Media $media */
        $media = $this->getFirstMedia('covers');

        if ($color = $media?->getCustomProperty('color')) {
            return $color;
        }

        return '#ffffff';
    }

    private function getCover(string $conversion = ''): string
    {
        /** @var Book|Author|Serie $that */
        $that = $this;
        $image = $that->meta_class_snake_plural === 'authors' ? 'no-author' : 'no-cover';
        $default = config('app.url')."/vendor/images/{$image}.webp";

        $medias = $this->getMedia('covers');
        if ($medias->isEmpty()) {
            return $default;
        }

        $media = $medias->first();
        $path = $media->getPath($conversion);

        if (file_exists($path)) {
            return $media->getUrl($conversion);
        } else {
            $path = $media->getPath();
            if (file_exists($path)) {
                return $media->getUrl();
            }
        }

        return $default;
    }
}
