<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Book\BookSerieResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Tag\TagLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
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
		$resource = SerieLightResource::make($this->resource)->toArray($request);
		$resource = array_merge($resource, [
			'description' => $this->resource->description,
			'link' => $this->resource->link,
			'language' => $this->resource->language?->slug,
			'picture' => [
				'base' => $this->resource->image_thumbnail,
				'openGraph' => $this->resource->image_open_graph,
				'simple' => $this->resource->image_simple,
				'color' => $this->resource->image_color,
			],
			'tags' => TagLightResource::collection($this->resource->tags_list),
			'genres' => TagLightResource::collection($this->resource->genres_list),
			'download' => $this->resource->download_link,
			'size' => $this->resource->size,
			// 'books'      => BookSerieResource::collection($this->resource->books),
			'isFavorite' => $this->resource->is_favorite,
			'comments' => CommentResource::collection($this->resource->comments),
		]);

		return $resource;
	}
}
