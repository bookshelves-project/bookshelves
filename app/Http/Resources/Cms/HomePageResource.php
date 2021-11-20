<?php

namespace App\Http\Resources\Cms;

use App\Models\Book;
use App\Models\Cms\HomePage;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property HomePage $resource
 */
class HomePageResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        $lang = $request->lang ?? 'en';
        app()->setLocale($lang);

        return [
            'hang' => [
                'title' => $this->resource->hang_title,
                'text' => $this->resource->hang_text,
                'picture' => $this->resource->hang_picture,
            ],
            'statistics' => $this->resource->display_statistics ? [
                'eyebrow' => $this->resource->statistics_eyebrow,
                'title' => $this->resource->statistics_title,
                'text' => $this->resource->statistics_text,
                'list' => $this->setStatistics(),
            ] : false,
            'logos' => $this->resource->display_logos ? [
                'title' => $this->resource->logos_title,
                'list' => $this->setLogos(),
            ] : false,
            'features' => $this->resource->display_features ? [
                'title' => $this->resource->features_title,
                'text' => $this->resource->features_text,
                'list' => $this->setFeatures(),
            ] : false,
            'display_latest' => $this->resource->display_latest,
            'display_selection' => $this->resource->display_selection,
        ];
    }

    private function setStatistics(): array
    {
        $statistics = json_decode(json_encode($this->resource->statistics));
        $locale = config('app.locale');

        foreach ($statistics as $key => $statistic) {
            $model = 'App\Models\\'.ucfirst($statistic->count);
            $count = 0;

            if ($statistic->countWhere) {
                $count = $model::where($statistic->countWhere[0], $statistic->countWhere[1])
                    ->count()
                ;
            } else {
                $count = $model::count();
            }

            $statistics[$key]->count = $count;
            $statistics[$key]->label = $statistic->label->{$locale};
        }

        return $statistics;
    }

    private function setLogos(): array
    {
        $logos = $this->resource->logos;
        $logos_with_media = [];

        foreach ($logos as $logo) {
            /** @var Media $media */
            $media = $this->resource->getFirstMedia('cms_logos')
                ->where('name', $logo['slug'])
                ->first()
            ;
            $logo['media'] = $media->getFullUrl();

            $logos_with_media[] = $logo;
        }

        return $logos_with_media;
    }

    private function setFeatures(): array
    {
        $features = json_decode(json_encode($this->resource->features));
        $locale = config('app.locale');
        $features_with_media = [];

        foreach ($features as $feature) {
            /** @var null|Media $media */
            $media = $this->resource->getFirstMedia('cms_features')
                ->where('name', $feature->icon)
                ->first()
            ;
            $feature->media = $media ? $media->getFullUrl() : null;
            $feature->title = $feature->title->{$locale};
            $feature->text = $feature->text->{$locale};

            $features_with_media[] = $feature;
        }

        return $features_with_media;
    }
}
