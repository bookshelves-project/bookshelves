<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use App\Utils\BookshelvesTools;
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
            'summary'     => BookshelvesTools::stringLimit($book->description, 140),
            'language'    => $book->language?->slug,
            'publishDate' => $book->date,
            'picture'     => [
                'base'      => $book->image_thumbnail,
                'openGraph' => $book->image_open_graph,
            ],
            'publisher'    => PublisherResource::make($book->publisher),
            'volume'       => $book->volume,
            'meta'         => [
                'show'        => $book->show_link,
            ],
        ];

        return $base;
    }
}
