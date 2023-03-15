<?php

namespace App\Traits;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Manage avatar with conversions with `spatie/laravel-medialibrary`.
 */
trait HasAvatar
{
    use InteractsWithMedia;

    /** @mixin \Spatie\Cover\Manipulations */
    public function registerMediaConversions(Media $media = null): void
    {
        $avatar = config('image.user.avatar');
        $banner = config('image.user.banner');

        if ('local' !== config('app.env')) {
            $this->addMediaConversion('avatar')
                ->crop(Manipulations::CROP_TOP, $avatar['width'], $avatar['height'])
                ->format(config('bookshelves.cover_extension'))
            ;
            $this->addMediaConversion('banner')
                ->crop(Manipulations::CROP_TOP, $banner['width'], $banner['height'])
                ->format(config('bookshelves.cover_extension'))
            ;
        }
    }

    public function getAvatarAttribute(): string
    {
        return $this->getAvatar();
    }

    /**
     * Get cover thumbnail with `spatie/laravel-medialibrary`
     * With config/bookshelves define format.
     */
    public function getAvatarThumbnailAttribute(): string|null
    {
        return $this->getAvatar('thumbnail');
    }

    public function getColorAttribute(): string|null
    {
        /** @var Media $media */
        $media = $this->getFirstMedia('avatar');
        // @phpstan-ignore-next-line
        $color = $media?->getCustomProperty('color');

        return "#{$color}";
    }

    public function getBannerAttribute(): string
    {
        return $this->getFirstMediaUrl('banner');
    }

    private function getAvatar(string $collection = '')
    {
        if ($this->use_gravatar) {
            $hash = md5(strtolower(trim($this->email)));

            return "http://www.gravatar.com/avatar/{$hash}";
        }

        if ($this->getMedia('avatar')->first()) {
            return $this->getFirstMediaUrl('avatar', $collection);
        }

        return 'https://eu.ui-avatars.com/api/?name='.$this->name.'&color=7F9CF5&background=EBF4FF';
    }
}
