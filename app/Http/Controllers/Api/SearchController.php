<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\Searching;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('search')]
class SearchController extends Controller
{
    #[Get('/', name: 'api.search.index')]
    public function index(Request $request)
    {
        $searchInput = $request->input('search');
        $limitInput = $request->input('limit', false);
        if (! $searchInput) {
            return [];
        }
        $search = Searching::search($searchInput, $limitInput);

        return $search->results();
    }
}
