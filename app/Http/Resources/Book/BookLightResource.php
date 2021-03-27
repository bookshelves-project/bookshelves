<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use App\Http\Resources\Serie\SerieLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'serie'        => SerieLightResource::make($book->serie, true),
        ]);

        return $resource;
    }
}
