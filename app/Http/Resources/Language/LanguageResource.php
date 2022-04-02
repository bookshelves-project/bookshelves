<?php

namespace App\Http\Resources\Language;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Language $resource
 */
class LanguageResource extends JsonResource
{
    /**
     * Transform the Language into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $resource = (array) LanguageLightResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
            'first_char' => $this->resource->first_char,
            'count' => $this->resource->books_count,
            'meta' => [
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
            ],
        ]);
    }
}
