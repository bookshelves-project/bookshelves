<?php

namespace App\Http\Resources\Search;

use App\Utils\BookshelvesTools;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class SearchBookResource extends JsonResource
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
		$serie = null;
		if ($this->resource->serie) {
			$serie = [
				'title' => $this->resource->serie->title,
				'number' => $this->resource->volume,
			];
		}

		return [
			'meta' => [
				'entity' => 'book',
				'author' => $this->resource->author->slug,
				'slug' => $this->resource->slug,
			],
			'title' => $this->resource->title,
			'subtitle' => $this->resource->serie?->title,
			'author' => $this->resource->author->name,
			'serie' => $serie,
			'picture' => [
				'base' => $this->resource->image_thumbnail,
				'openGraph' => $this->resource->image_open_graph,
				'color' => $this->resource->image_color,
			],
			'text' => BookshelvesTools::stringLimit($this->resource->description, 140),
		];
	}
}
