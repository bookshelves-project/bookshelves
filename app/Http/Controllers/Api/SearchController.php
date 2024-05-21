<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Kiwilan\Steward\Engines\SearchEngine;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('search')]
class SearchController extends Controller
{
    #[Get('/', name: 'api.search.index')]
    public function index(Request $request)
    {
        $query = $request->input('search');
        $limit = $request->input('limit', null);

        if (! $query) {
            return [];
        }

        $search = SearchEngine::make($query, [Book::class, Serie::class, Author::class])
            ->limit($limit)
            ->get();

        return response()->json([
            'query' => $search->getQuery(),
            'limit' => $search->getLimit(),
            'count' => $search->getCount(),
            'data' => $search->toResource(SearchResource::class, flatten: true),
        ]);
    }
}
