<?php

namespace App\Http\Resources;

use Str;
use Auth;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
        $serie = null;
        $epub = null;
        $publisher = null;
        $language = null;
        if ($this->serie) {
            $serie = new SerieResource($this->serie);
        }
        $authors = null;
        if ($this->authors) {
            $authors = AuthorCollection::collection($this->authors);
        }
        if ($this->publisher) {
            $publisher = new PublisherResource($this->publisher);
        }
        if ($this->language) {
            $language = $this->language;
        }
        $tags = null;
        if ($this->tags) {
            $tags = TagCollection::collection($this->tags);
        }
        $summary = null;
        if (null !== $this->description) {
            $html = $this->description;
            $isUTF8 = mb_check_encoding($html, 'UTF-8');
            $summary = iconv('UTF-8', 'UTF-8//IGNORE', $html);

            if ($isUTF8) {
                // $summary = Html2Text::convert($html);
                if (strlen($summary) > 165) {
                    $summary = substr($summary, 0, 165).'...';
                }
                $summary = strip_tags($summary);
                $summary = Str::ascii($summary);
            }
        }
        $user = Auth::user();
        $isFavorite = false;
        if ($user) {
            $entity = Book::whereSlug($this->slug)->first();

            $checkIfFavorite = Book::find($entity->id)->favorites;
            if (! sizeof($checkIfFavorite) < 1) {
                $isFavorite = true;
            }
        }
        $comments = null;
        if ($this->comments) {
            $comments = CommentCollection::collection($this->comments);
        }

        $epub = null;
        if ($this->getMedia('books_epubs')) {
            $epub = $this->getMedia('books_epubs')->first();
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => $this->author->slug,
            'authors'               => $authors,
            'summary'               => $summary,
            'description'           => $this->description,
            'language'              => [
                'slug' => $language->slug,
                'flag' => $language->flag,
            ],
            'publishDate'                   => $this->date,
            'isbn'                          => IdentifierResource::make($this->identifier),
            'publisher'                     => $publisher,
            'image'                         => $this->image_thumbnail,
            'imageOriginal'                 => $this->image_original,
            'tags'                          => $tags,
            'epub'                          => [
                'name'     => $epub->file_name,
                'size'     => human_filesize($epub->size),
                'download' => $this->download_link,
            ],
            'serie'                 => $serie ? [
                'number'  => $this->serie_number,
                'title'   => $serie->title,
                'slug'    => $serie->slug,
                'show'    => $serie->show_link,
            ] : null,
            'isFavorite' => $isFavorite,
            'comments'   => $comments,
        ];
    }
}
