<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Author\AuthorUltraLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieLightResource extends JsonResource
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
		$resource = SerieUltraLightResource::make($this->resource)->toArray($request);
		$resource = array_merge($resource, [
			'language' => $this->resource->language?->slug,
			'authors' => AuthorUltraLightResource::collection($this->resource->authors),
			'count' => $this->resource->books_count,
		]);

		return $resource;
	}
}
