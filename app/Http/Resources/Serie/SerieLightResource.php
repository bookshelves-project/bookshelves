<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\Language\LanguageLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieLightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $resource = SerieUltraLightResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
            'language' => LanguageLightResource::make($this->resource->language),
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'count' => $this->resource->books_count,
        ]);
    }
}
