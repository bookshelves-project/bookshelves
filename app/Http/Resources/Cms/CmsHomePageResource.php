<?php

namespace App\Http\Resources\Cms;

use App\Models\Book;
use App\Models\Cms\CmsHomePage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property CmsHomePage $resource
 */
class CmsHomePageResource extends JsonResource
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
            'hero' => [
                'title' => $this->resource->hero_title,
                'text' => $this->resource->hero_text,
                'picture' => $this->resource->hero_picture,
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
        $data = [];
        foreach ($this->resource->statistics as $model) {
            array_push($data, [
                'label' => $model->label,
                'link' => $model->link,
                'count' => $model->count,
            ]);
        }

        return $data;
    }

    private function setLogos(): array
    {
        $data = [];
        foreach ($this->resource->logos as $model) {
            array_push($data, [
                'label' => $model->label,
                'slug' => $model->slug,
                'link' => $model->link,
                'picture' => $model->picture,
            ]);
        }

        return $data;
    }

    private function setFeatures(): array
    {
        $data = [];
        foreach ($this->resource->features as $model) {
            array_push($data, [
                'title' => $model->title,
                'text' => $model->text,
                'link' => $model->link,
                'picture' => $model->picture,
            ]);
        }

        return $data;
    }
}
