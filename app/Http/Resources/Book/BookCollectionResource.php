<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Serie\SerieCollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'meta' => $this->resource->meta,
            'title' => $this->resource->title,
            'type' => $this->resource->type,
            'serie' => SerieCollectionResource::make($this->resource->serie),
            'volume' => $this->resource->volume,
        ];
    }
}
