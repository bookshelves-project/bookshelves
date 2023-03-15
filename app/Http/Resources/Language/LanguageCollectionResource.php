<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Language $resource
 */
class LanguageCollectionResource extends JsonResource
{
    /**
     * Transform the Language into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'meta' => [
                'slug' => $this->resource->slug,
                // 'show' => $this->resource->show_link,
            ],
        ];
    }
}
