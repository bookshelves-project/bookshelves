<?php

namespace App\Http\Resources;

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
        return [
            'name' => $this->resource->name,
            'first_char' => $this->resource->first_char,
            'count' => $this->resource->books_count,
            'meta' => [
                'slug' => $this->resource->slug,
                'show' => $this->resource->show_link,
            ],
        ];
    }
}
