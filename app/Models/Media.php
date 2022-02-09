<?php

namespace App\Models;

use League\Glide\Urls\UrlBuilderFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as ModelsMedia;

class Media extends ModelsMedia
{
    protected $glide;

    public function glide(array $params): self
    {
        $this->glide = $params;

        return $this;
    }

    public function getUrl(string $conversionName = ''): string
    {
        $url = parent::getUrl($conversionName);

        if (! $this->glide) {
            return $url;
        }

        $urlBuilder = UrlBuilderFactory::create('/glide/', config('glide.key'));

        return $urlBuilder->getUrl(ltrim($url, '/storage'), $this->glide);
    }
}
