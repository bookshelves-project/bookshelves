<?php

namespace App\Traits;

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
 * @property string $cover_opds
 * @property string $cover_square
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

    private const CONVERSION_SQUARE = 'square';

    public function initializeHasCovers(): void
    {
        $this->fillable = array_merge($this->fillable, [
            'has_cover',
        ]);

        $this->appends = array_merge($this->appends, [
            'cover_standard',
            'cover_thumbnail',
            'cover_social',
            'cover_square',
            'cover_color',
            'cover_path',
        ]);

        $this->casts = array_merge($this->casts, [
            'has_cover' => 'boolean',
        ]);
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        /** @var Book|Author|Serie|null $model */
        $model = $media->getModel()->model_type::find($media->getModel()->model_id);
        if (! $model) {
            return;
        }

        $name = $model->title;
        if ($model instanceof Author) {
            $name = $model->name;
        } else {
            $model->loadMissing('library');
            $name = "{$name} ({$model->library?->name})";
        }

        $formatThumbnail = Bookshelves::imageCoverThumbnail();
        $formatStandard = Bookshelves::imageCoverStandard();
        $formatSocial = Bookshelves::imageCoverSocial();
        $formatOpds = Bookshelves::imageCoverOpds();
        $formatSquare = Bookshelves::imageCoverSquare();

        if (Bookshelves::convertCovers()) {
            if (Bookshelves::verbose()) {
                Journal::debug('Registering media conversions for '.$name);
            }

            $thumbnail_width = $formatThumbnail['width'];
            $thumbnail_height = $formatThumbnail['height'];

            $standard_width = $formatStandard['width'];
            $standard_height = $formatStandard['height'];

            $social_width = $formatSocial['width'];
            $social_height = $formatSocial['height'];

            $opds_width = $formatOpds['width'];
            $opds_height = $formatOpds['height'];

            $square_width = $formatSquare['width'];
            $square_height = $formatSquare['height'];

            if ($this instanceof Book) {
                if ($this->is_audiobook) {
                    $thumbnail_width = $square_width;
                    $thumbnail_height = $square_height;

                    $standard_width = $square_width;
                    $standard_height = $square_height;

                    $social_width = $square_width;
                    $social_height = $square_height;

                    $opds_width = $square_width;
                    $opds_height = $square_height;
                }
            }

            $this->addMediaConversion(self::CONVERSION_THUMBNAIL)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $thumbnail_width, $thumbnail_height)
                ->format(Bookshelves::imageFormat());

            $this->addMediaConversion(self::CONVERSION_STANDARD)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $standard_width, $standard_height)
                ->format(Bookshelves::imageFormat());

            $this->addMediaConversion(self::CONVERSION_SOCIAL)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $social_width, $social_height)
                ->format('jpg');

            $this->addMediaConversion(self::CONVERSION_OPDS)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $opds_width, $opds_height)
                ->format('jpg');

            $this->addMediaConversion(self::CONVERSION_SQUARE)
                ->performOnCollections(Bookshelves::imageCollection())
                ->fit(Fit::Crop, $square_width, $square_height)
                ->format(Bookshelves::imageFormat());
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

    /**
     * Get cover square with `spatie/laravel-medialibrary`
     */
    public function getCoverSquareAttribute(): ?string
    {
        return $this->getCover(self::CONVERSION_SQUARE);
    }

    public function hasCoverCollection(): bool
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

    public function getCoverPathAttribute(): ?string
    {
        if (! $this->relationLoaded('media')) {
            return null;
        }

        /** @var ?Media $media */
        $media = $this->getFirstMedia(Bookshelves::imageCollection());

        return $media?->getPath();
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
