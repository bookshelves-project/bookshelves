<?php

namespace App\Http\Resources\Language;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Language $resource
 */
class LanguageResource extends JsonResource
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
            ...LanguageCollectionResource::make($this->resource)->toArray($request),
            // 'first_char' => $this->resource->first_char,
            'count' => $this->resource->books_count,
        ];
    }
}
