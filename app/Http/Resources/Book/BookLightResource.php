<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Serie\SerieUltraLightResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookLightResource extends JsonResource
{
	/**
	 * Transform the Book into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @mixin Book
	 */
	public function toArray($request): array
	{
		$resource = BookUltraLightResource::make($this->resource)->toArray($request);
		$resource = array_merge($resource, [
			'serie' => SerieUltraLightResource::make($this->resource->serie, true),
		]);

		return $resource;
	}
}
