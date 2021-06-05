<?php

namespace App\Http\Resources\Serie;

use App\Models\Serie;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Tag\TagLightResource;
use App\Http\Resources\Book\BookSerieResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieResource extends JsonResource
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
        /** @var Serie $serie */
        $serie = $this;

        $resource = SerieLightResource::make($serie)->toArray($request);
        $resource = array_merge($resource, [
            'description'     => $serie->description,
            'link'            => $serie->link,
            'language'        => $serie->language?->slug,
            'picture'         => [
                'base'      => $serie->image_thumbnail,
                'openGraph' => $serie->image_open_graph,
                'color'     => $this->resource->image_color,
            ],
            'tags'             => TagLightResource::collection($serie->tags_list),
            'genres'           => TagLightResource::collection($serie->genres_list),
            'download'         => $serie->download_link,
            'size'             => $serie->size,
            'books'            => BookSerieResource::collection($serie->books),
            'isFavorite'       => $serie->is_favorite,
            'comments'         => CommentResource::collection($serie->comments),
        ]);

        return $resource;
    }
}
