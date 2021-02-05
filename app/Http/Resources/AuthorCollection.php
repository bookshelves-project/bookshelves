<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $books = null;
        $cover = null;
        if ($this->books) {
            $books = BookCollection::collection($this->books);
            $books_number = sizeof($books);
            $book = $books->random();

            try {
                $mainBook = Book::with('author')->where('serie_number', '=', '1')->whereAuthorId($this->id)->first();
            } catch (\Throwable $th) {
            }
            if (null === $mainBook) {
                $mainBook = $books->first();
            }
            try {
                $cover = $mainBook->cover->thumbnail;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        // $authorName = str_replace(' ', '%20', $this->name);
        // $wiki_url = "https://en.wikipedia.org/w/api.php?action=query&origin=*&titles=$authorName&prop=pageimages&format=json&pithumbsize=512";

        // $response = Http::get($wiki_url);
        // $photoRaw = reset($response->json()['query']['pages']);
        // $photo = null;
        // if (array_key_exists('thumbnail', $photoRaw)) {
        //     $photo = $photoRaw['thumbnail']['source'];
        // }

        return [
            'lastname'       => $this->lastname,
            'firstname'      => $this->firstname,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'books_number'   => $books_number,
            'cover'          => $cover,
            'picture'        => $this->picture ? config('app.url').'/storage/'.$this->picture : null,
            'links'          => [
                'show' => config('app.url')."/api/authors/$this->slug",
            ],
        ];
    }
}
