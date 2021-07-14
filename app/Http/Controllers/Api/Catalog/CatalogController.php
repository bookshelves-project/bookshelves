<?php

namespace App\Http\Controllers\Api\Catalog;

use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;

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
}
