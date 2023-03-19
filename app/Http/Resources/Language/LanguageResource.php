<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Language $resource
 */
class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...LanguageCollection::make($this->resource)->toArray($request),
            // 'first_char' => $this->resource->first_char,
            'count' => $this->resource->books_count,
        ];
    }
}
