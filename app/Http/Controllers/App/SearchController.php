<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Kiwilan\Steward\Engines\SearchEngine;
use Spatie\RouteAttributes\Attributes\Get;

class SearchController extends Controller
{
    #[Get('/search', name: 'search.index')]
    public function index(Request $request)
    {
        $query = $request->input('search');
        $search = SearchEngine::make($query, [Author::class, Serie::class, Book::class])->get();

        return inertia('Search', [
            'query' => $search->getQuery(),
            'limit' => $search->getLimit(),
            'count' => $search->getCount(),
            'data' => $search->toResource(SearchResource::class, flatten: true),
        ]);
    }
}
