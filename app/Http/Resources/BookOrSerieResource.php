<?php

namespace App\Http\Resources;

use App\Http\Resources\Author\AuthorUltraLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
				'author' => $this->resource->author->slug,
				'slug' => $this->resource->slug,
			],
			'title' => $this->resource->title,
			'authors' => AuthorUltraLightResource::collection($this->resource->authors),
			'picture' => [
				'base' => $this->resource->image_thumbnail,
				'original' => $this->resource->image_original,
				'openGraph' => $this->resource->image_open_graph,
				'color' => $this->resource->image_color,
			],
		];
	}
}
