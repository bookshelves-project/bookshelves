<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;
use League\Glide\Urls\UrlBuilderFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class MediaExtended extends BaseMedia
{
    /**
     * @param  Collection<int, ?BaseMedia>  $medias
     * @return Collection<int, MediaExtended>
     */
    public static function fromMedias(Collection|array $medias): Collection
    {
        if (is_array($medias)) {
            $medias = collect($medias);
        }

        return $medias->map(fn (?BaseMedia $media) => $media instanceof BaseMedia ? new self($media->attributes) : null);
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value,
        );
    }

    public function getSizeHumanAttribute(): string|null
    {
        return $this->humanFilesize($this->size);
    }

    public function getFullExtensionAttribute(): string|null
    {
        return $this->getTypeFromExtension();
    }

    public function getDownloadAttribute(): string|null
    {
        return $this->getUrl();
    }

    public function humanFilesize(string|int $bytes, ?int $decimals = 2): string
    {
        $sz = [
            'B',
            'Ko',
            'Mo',
            'Go',
            'To',
            'Po',
        ];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$sz[$factor];
    }

    public function getUrl(string $conversionName = ''): string
    {
        // $url = parent::getUrl($conversionName);

        // if (! $this->glide) {
        //     return $url;
        // }

        // $urlBuilder = UrlBuilderFactory::create('/glide/', config('glide.key'));

        // return $urlBuilder->getUrl(ltrim($url, '/storage'), $this->glide);

        return '';
    }
}
