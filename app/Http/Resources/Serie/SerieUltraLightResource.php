<?php

namespace App\Http\Resources\Serie;

use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieUltraLightResource extends JsonResource
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

		$base = [
			'title' => $serie->title,
			'picture' => [
				'base' => $serie->image_thumbnail,
				'simple' => $serie->image_simple,
				'color' => $this->resource->image_color,
			],
			'meta' => [
				'slug' => $serie->slug,
				'author' => $serie->author?->slug,
				'show' => $serie->show_link,
			],
		];

		return $base;
	}
}
