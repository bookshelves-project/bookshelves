<?php

namespace App\Http\Controllers\Api;

use App\Engines\SearchEngine;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Search
 *
 * APIs for Search.
 */
#[Prefix('search')]
class SearchController extends ApiController
{
    #[Get('/', name: 'api.search.index')]
    public function index(Request $request)
    {
        $q = $request->input('q');
        $types = $request->input('types');

        $service = SearchEngine::create(
            q: $q,
            types: $types
        );

        return $service->json();
    }
}
