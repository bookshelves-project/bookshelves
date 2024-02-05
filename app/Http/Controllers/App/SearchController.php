<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Utils\Searching;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class SearchController extends Controller
{
    #[Get('/search', name: 'search.index')]
    public function index(Request $request)
    {
        $searchInput = $request->input('search');
        $search = Searching::search($searchInput, false);

        return inertia('Search', [
            'search' => $searchInput,
            'results' => $search->results(),
        ]);
    }
}
