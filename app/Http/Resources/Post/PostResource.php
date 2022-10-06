<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            ...PostCollectionResource::make($this->resource)->toArray($request),
            'body' => $this->resource->body,
        ];
    }
}
