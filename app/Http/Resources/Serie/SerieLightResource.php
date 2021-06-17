<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

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
		/** @var Serie $serie */
		$serie = $this;

		$resource = SerieUltraLightResource::make($serie)->toArray($request);
		$resource = array_merge($resource, [
			'language' => $serie->language?->slug,
			'authors' => AuthorUltraLightResource::collection($serie->authors),
			'count' => $serie->books()->count(),
		]);

		return $resource;
	}
}
