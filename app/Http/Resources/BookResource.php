<?php

namespace App\Http\Resources;

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
        $author = null;
        $epub = null;
        $publisher = null;
        $language = null;
        if ($this->serie) {
            $serie = new SerieResource($this->serie);
        }
        if ($this->author) {
            $author = $this->author;
        }
        if ($this->epub) {
            $epub = new EpubResource($this->epub);
        }
        if ($this->publisher) {
            $publisher = new PublisherResource($this->publisher);
        }
        if ($this->language) {
            $language = $this->language;
        }
        if ($this->cover) {
            $cover = $this->cover;
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => $author ? [
                'name'        => $author->name,
                'slug'        => $author->slug,
                'firstname'   => $author->firstname,
                'lastname'    => $author->lastname,
                'show'        => config('app.url')."/api/authors/$author->slug",
            ] : null,
            'description'           => $this->description,
            'language'              => [
                'slug' => $language->slug,
                'flag' => $language->flag,
            ],
            'publishDate'           => $this->publish_date,
            'isbn'                  => $this->isbn,
            'publisher'             => $publisher,
            'cover'                 => [
                'basic'   => $cover->basic,
                'thumbnail' => $cover->thumbnail,
                'original'  => $cover->original,
            ],
            'epub'                  => $epub ? $epub : null,
            'serie'                 => $serie ? [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $serie ? $serie->title : null,
                'show'    => config('app.url')."/api/series/$serie->slug",
            ] : null,
        ];
    }
}
