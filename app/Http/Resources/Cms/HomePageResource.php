<?php

namespace App\Http\Resources\Cms;

use App\Models\Book;
use App\Models\Cms\HomePage\HomePage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property HomePage $resource
 */
class HomePageResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
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
            'highlights' => $this->resource->display_highlights
                ? $this->setHighlights()
                : false,
            'displayLatest' => $this->resource->display_latest,
            'displaySelection' => $this->resource->display_selection,
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

    private function setHighlights(): array
    {
        $data = [];
        foreach ($this->resource->highlights as $model) {
            array_push($data, [
                'title' => $model->title,
                'text' => $model->text,
                'ctaText' => $model->cta_text,
                'ctaLink' => $model->cta_link,
                'quoteText' => $model->quote_text,
                'quoteAuthor' => $model->quote_author,
                'icon' => $model->icon,
                'picture' => $model->picture,
            ]);
        }

        return $data;
    }
}
