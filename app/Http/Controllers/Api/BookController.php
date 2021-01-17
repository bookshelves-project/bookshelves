<?php

namespace App\Http\Controllers\Api;

use Storage;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage');
        $debug = $request->get('debug');
        $booksWithSerie = Book::whereNotNull('serie_id')->orderBy('serie_id')->orderBy('serie_number')->get();
        $booksWithoutSerie = Book::whereNull('serie_id')->orderBy('title')->get();

        $articles = [
            'The',
            'Les',
            "L'",
            'Le',
            'La',
        ];
        $books = $booksWithSerie->merge($booksWithoutSerie);
        $books = $books->sortBy(function ($book, $key) use ($articles) {
            $title = null;
            if ($book->serie) {
                $title = $book->serie->title;
                $title = str_replace($articles, '', $title);
                $title = stripAccents($title);
            } else {
                $title = $book->title;
            }

            echo $title.'<br/>';

            return $title;
        });
        if (null !== $perPage) {
            $books = $books->paginate($perPage);
        }

        if ($debug) {
            foreach ($books as $book) {
                if ($book->serie) {
                    echo $book->serie->title.' '.$book->serie_number.' '.$book->title.'<br>';
                } else {
                    echo $book->title.'<br>';
                }
            }
        } else {
            $books = BookCollection::collection($books);

            return $books;
        }
    }

    public function count()
    {
        return Book::count();
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['title', 'author.firstname', 'author.lastname', 'serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return BookResource::collection($books);
    }

    public function show(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorId($author->id)->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        return $book;
    }

    public function download(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorId($author->id)->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        $ebook_path = str_replace('storage/', '', $book->epub->path);

        return Storage::disk('public')->download($ebook_path);
    }
}
