<?php

namespace App\Http\Resources\Api\Post;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = (array) PostCollectionResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
            'body' => $this->resource->body,
        ]);
    }
}
