<?php

namespace App\Http\Resources\Publisher;

use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherLightResource extends JsonResource
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
		/** @var Publisher $publisher */
		$publisher = $this;

		return [
			'name' => $publisher->name,
			'slug' => $publisher->slug,
			'count' => $publisher->books->count(),
			'meta' => [
				'show' => route('api.publishers.show', [
					'publisher' => $publisher->slug,
				]),
			],
		];
	}
}
