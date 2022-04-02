<?php

namespace App\Http\Resources\Publisher;

use App\Http\Resources\Search\SearchBookResource;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Publisher $resource
 */
class PublisherResource extends JsonResource
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
        $resource = PublisherLightResource::make($this->resource)->toArray($request);

        return array_merge($resource);
    }
}
