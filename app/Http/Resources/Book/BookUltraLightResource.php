<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use App\Utils\Tools;
use App\Http\Resources\PublisherResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

class BookUltraLightResource extends JsonResource
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

        $base = [
            'title'       => $book->title,
            'slug'        => $book->slug,
            'author'      => $book->author?->slug,
            'authors'     => AuthorUltraLightResource::collection($book->authors),
            'summary'     => Tools::stringLimit($book->description, 140),
            'language'    => $book->language?->slug,
            'publishDate' => $book->date,
            'picture'     => [
                'base' => $book->image_thumbnail,
            ],
            'publisher'    => PublisherResource::make($book->publisher),
            'serieVolume'  => $book->serie_number,
            'meta'         => [
                'show'        => $book->show_link,
            ],
        ];

        return $base;
    }
}
