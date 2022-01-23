<?php

namespace App\Http\Resources\Admin;

use App\Models\PostCategory;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property PostCategory $resource
 */
class PostCategoryResource extends JsonResource
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
        return $this->resource->only('id', 'name', 'slug');
    }
}
