<?php

namespace App\Http\Resources\Serie;

use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

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
            'authors'     => AuthorUltraLightResource::collection($serie->authors),
            'booksNumber' => count($serie->books),
        ]);

        return $resource;
    }
}
