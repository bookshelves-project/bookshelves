<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

class BookOrSerieResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $entity = str_replace('App\Models\\', '', $this->resource::class);
        $entity = strtolower($entity);

        return [
            'meta' => [
                'entity' => $entity,
                'author' => $this->resource->meta_author,
                'slug'   => $this->resource->slug,
            ],
            'title'   => $this->resource->title,
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'volume'  => $this->resource->volume ? $this->resource->volume : null,
            'picture' => [
                'base'      => $this->resource->image_thumbnail,
                'original'  => $this->resource->image_original,
                'openGraph' => $this->resource->image_open_graph,
                'color'     => $this->resource->image_color,
            ],
        ];
    }
}
