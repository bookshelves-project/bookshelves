<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Spatie\Tags\Tag;
use App\Models\Author;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }

    public function show(string $tag)
    {
        $tag = Tag::whereSlug($tag)->first();

        return TagResource::make($tag);
    }

    public function book(string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($book)->firstOrFail();

        // $all_books = collect();
        // $tags = $book->tags;
        // foreach ($tags as $key => $tag) {
        //     dump($tag->books);
        //     foreach ($tag->books as $key => $value) {
        //         $all_books = $all_books->push($value->slug);
        //     }
        //     // $books_selected = $tag->books->slice(0, 5);
        //     // foreach ($books_selected as $key => $book_selected) {
        //     //     dump($book_selected->slug);
        //     // }
        // }
        // $all_books_unique = $all_books->unique();
        // dump($all_books_unique);
        // foreach ($all_books_unique as $key => $book_value) {
        //     // dump($book_value);
        // }

        $tags = [];
        foreach ($book->tags as $tag) {
            array_push($tags, $tag->name);
        }
        $books = Book::withAllTags($tags)->get();

        // echo $book->title;
        // foreach ($book->tags as $tag) {
        //     echo $tag->name . '<br>';
        // }
        // echo '<br>';

        // foreach ($books as $book) {
        //     echo $book->title . '<br>';
        //     foreach ($book->tags as $tag) {
        //         echo $tag->name . '<br>';
        //     }
        //     echo '<br>';
        // }

        return BookLightResource::collection($books);
    }
}
