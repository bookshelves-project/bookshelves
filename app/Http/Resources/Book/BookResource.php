<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use App\Utils\BookshelvesTools;
use App\Http\Resources\TagResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GoogleBookResource;
use App\Http\Resources\IdentifierResource;
use App\Http\Resources\Serie\SerieLightResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

/**
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        // $this->resource->title;

        /** @var Book $book */
        $book = $this;

        $resource = BookLightResource::make($book)->toArray($request);
        $resource = array_merge($resource, [
            'serie'   => SerieLightResource::make($book->serie),
            'authors' => AuthorUltraLightResource::collection($book->authors),
            'picture' => [
                'base'      => $book->image_thumbnail,
                'openGraph' => $book->image_open_graph,
                'original'  => $book->image_original,
                'color'     => $this->resource->image_color,
            ],
            'description'    => $book->description,
            'identifier'     => IdentifierResource::make($book->identifier),
            'pageCount'      => $book->page_count,
            'maturityRating' => $book->maturity_rating,
            'tags'           => TagResource::collection($book->tags),
            'epub'           => [
                'name'     => $book->getMedia('epubs')->first()->file_name,
                'size'     => BookshelvesTools::humanFilesize($book->getMedia('epubs')->first()->size),
                'download' => $book->download_link,
            ],
            'googleBook' => GoogleBookResource::make($book->googleBook),
            'isFavorite' => $book->is_favorite,
            'comments'   => CommentResource::collection($book->comments),
        ]);

        return $resource;
    }
}
