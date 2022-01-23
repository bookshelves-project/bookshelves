<?php

namespace App\Http\Resources\Admin;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Post $resource
 */
class PostResource extends JsonResource
{
    public static $wrap;

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
            'featured_image' => MediaResource::collection($this->whenLoaded('media')),
            'category' => PostCategoryResource::make($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'user' => UserResource::make($this->whenLoaded('user')),
        ] + $this->resource->toArray();
    }
}
