<?php

namespace App\Http\Resources\Publisher;

use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Publisher $resource
 */
class PublisherLightResource extends JsonResource
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
        return [
            'name' => $this->resource->name,
            'count' => $this->resource->books_count,
            'firstChar' => $this->resource->first_char,
            'meta' => [
                'slug' => $this->resource->slug,
                'books' => $this->resource->show_books_link,
                'show' => $this->resource->show_link,
            ],
        ];
    }
}
