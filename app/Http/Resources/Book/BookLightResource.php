<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Serie\SerieUltraLightResource;

class BookLightResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     *
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Book $book */
        $book = $this;

        $resource = BookUltraLightResource::make($book)->toArray($request);
        $resource = array_merge($resource, [
            'serie'        => SerieUltraLightResource::make($book->serie, true),
        ]);

        return $resource;
    }
}
