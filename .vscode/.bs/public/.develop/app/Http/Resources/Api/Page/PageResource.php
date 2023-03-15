<?php

namespace App\Http\Resources\Api\Page;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Page $resource
 */
class PageResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = (array) PageCollectionResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
            'body' => $this->resource->body,
        ]);
    }
}
