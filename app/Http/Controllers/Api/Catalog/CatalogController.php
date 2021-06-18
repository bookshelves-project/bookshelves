<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.api.catalog.index');
    }

    public function search(Request $request)
    {
        $searchTermRaw = $request->input('q');
        if ($searchTermRaw) {
            $collection = BookshelvesTools::searchGlobal($searchTermRaw);
            $authors = array_filter($collection, function ($item) {
                return 'author' == $item['meta']['entity'];
            });
            $authors = collect($authors);
            $series = array_filter($collection, function ($item) {
                return 'serie' == $item['meta']['entity'];
            });
            $series = collect($series);
            $books = array_filter($collection, function ($item) {
                return 'book' == $item['meta']['entity'];
            });
            $books = collect($books);

            return view('pages.api.catalog.search', compact('authors', 'series', 'books'));
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }

    public function series(Request $request)
    {
        $books = Book::orderBy('title_sort')->paginate(32);
        $books = BookLightResource::collection($books);
        $links = $books->onEachSide(1)->links();
        $books = json_decode($books->toJson());

        return view('pages.api.catalog.series.index', compact('books', 'links'));
    }

    public function authors(Request $request)
    {
        $books = Book::orderBy('title_sort')->paginate(32);
        $books = BookLightResource::collection($books);
        $links = $books->onEachSide(1)->links();
        $books = json_decode($books->toJson());

        return view('pages.api.catalog.authors.index', compact('books', 'links'));
    }
}
