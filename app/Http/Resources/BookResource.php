<?php

namespace App\Http\Resources;

use Str;
use Auth;
use App\Models\Book;
use Soundasleep\Html2Text;
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
        if ($this->epub) {
            $epub = new EpubResource($this->epub);
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
        $cover_basic = null;
        $cover_thumbnail = null;
        $cover_original = null;
        if ($this->cover) {
            $cover = $this->cover;

            $cover_basic = $cover->basic;
            $cover_thumbnail = $cover->thumbnail;
            $cover_original = $cover->original;
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

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'authorSlug'            => $this->author->slug,
            'authors'               => $authors,
            'summary'               => $summary,
            'description'           => $this->description,
            'language'              => [
                'slug' => $language->slug,
                'flag' => $language->flag,
            ],
            'publishDate'           => $this->date,
            'isbn'                  => $this->isbn,
            'publisher'             => $publisher,
            'cover'                 => [
                'basic'     => $cover_basic,
                'thumbnail' => $cover_thumbnail,
                'original'  => $cover_original,
            ],
            'tags'                  => $tags,
            'epub'                  => $epub ? $epub : null,
            'serie'                 => $serie ? [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $serie ? $serie->title : null,
                'slug'    => $serie ? $serie->slug : null,
                'show'    => config('app.url')."/api/series/$serie->slug",
            ] : null,
            'isFavorite' => $isFavorite,
            'comments'   => $comments,
        ];
    }
}
