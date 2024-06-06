<?php

namespace App\Traits;

use App\Enums\LibraryTypeEnum;
use App\Facades\Bookshelves;
use App\Models\Author;
use App\Models\Book;
use App\Models\MediaExtended;
use App\Models\Serie;
use Kiwilan\LaravelNotifier\Facades\Journal;
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

    private const CONVERSION_STANDARD = 'standard';

    private const CONVERSION_THUMBNAIL = 'thumbnail';

    private const CONVERSION_SOCIAL = 'social';

    private const CONVERSION_OPDS = 'opds';

    public function initializeHasCovers(): void
    {
        $this->appends = array_merge($this->appends, [
            'cover_standard',
            'cover_thumbnail',
            'cover_social',
            'cover_color',
        ]);
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $model_id = $media->getModel()->model_id;
        /** @var Book|Author|Serie $model */
        $model = $media->getModel()->model_type::find($model_id);

        $isSquare = false;
        if (property_exists($model, 'library')) {
            $model->loadMissing('library');
            if ($model->library && $model->library->type === LibraryTypeEnum::audiobook) {
                $isSquare = true;
            }
        }

        $formatThumbnail = Bookshelves::imageCoverThumbnail($isSquare);
        $formatStandard = Bookshelves::imageCoverStandard($isSquare);
        $formatSocial = Bookshelves::imageCoverSocial($isSquare);
        $formatOpds = Bookshelves::imageCoverOpds($isSquare);

        Journal::warning('Registering media conversions for '.$this->title, [
            'thumbnail' => $formatThumbnail,
            'standard' => $formatStandard,
            'social' => $formatSocial,
            'opds' => $formatOpds,
            'model' => $model->toArray(),
        ]);

        if (Bookshelves::convertCovers()) {
            $this->addMediaConversion(self::CONVERSION_THUMBNAIL)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $formatThumbnail['width'], $formatThumbnail['height'])
                ->sharpen(10)
                ->optimize()
                ->format(Bookshelves::imageFormat());

            $this->addMediaConversion(self::CONVERSION_STANDARD)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $formatStandard['width'], $formatStandard['height'])
                ->sharpen(10)
                ->optimize()
                ->format(Bookshelves::imageFormat());

            $this->addMediaConversion(self::CONVERSION_SOCIAL)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $formatSocial['width'], $formatSocial['height'])
                ->sharpen(10)
                ->optimize()
                ->format('jpg');

            $this->addMediaConversion(self::CONVERSION_OPDS)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $formatOpds['width'], $formatOpds['height'])
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
    public function getCoverMediaAttribute(): ?Media
    {
        return $this->getMedia(Bookshelves::imageCollection())->first() ?? null;
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
        return $this->getCover(self::CONVERSION_STANDARD);
    }

    /**
     * Get cover thumbnail with `spatie/laravel-medialibrary`
     */
    public function getCoverThumbnailAttribute(): ?string
    {
        return $this->getCover(self::CONVERSION_THUMBNAIL);
    }

    /**
     * Get cover social with `spatie/laravel-medialibrary`
     */
    public function getCoverSocialAttribute(): ?string
    {
        return $this->getCover(self::CONVERSION_SOCIAL);
    }

    /**
     * Get cover opds with `spatie/laravel-medialibrary`
     */
    public function getCoverOpdsAttribute(): ?string
    {
        return $this->getCover(self::CONVERSION_OPDS);
    }

    public function hasCover(): bool
    {
        return $this->getMedia(Bookshelves::imageCollection())->isNotEmpty();
    }

    public function clearCover(): void
    {
        $this->clearMediaCollection(Bookshelves::imageCollection());
    }

    /**
     * Get cover main color with `spatie/laravel-medialibrary`
     */
    public function getCoverColorAttribute(): ?string
    {
        if (! $this->relationLoaded('media')) {
            return '#ffffff';
        }

        /** @var ?Media $media */
        $media = $this->getFirstMedia(Bookshelves::imageCollection());

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
        $default = config('app.url')."/images/{$image}.webp";

        if (! $that->relationLoaded('media')) {
            return $default;
        }

        $medias = $this->getMedia(Bookshelves::imageCollection());
        if ($medias->isEmpty()) {
            return $default;
        }

        $media = $medias->first();
        if (! Bookshelves::convertCovers()) {
            return $media->getUrl();
        }
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
