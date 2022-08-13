<?php

namespace App\Http\Resources\Language;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Language $resource
 */
class LanguageLightResource extends JsonResource
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
            ],
        ];
    }
}
