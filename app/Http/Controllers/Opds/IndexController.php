<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsConfig;
use App\Engines\SearchEngine;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Kiwilan\Opds\Opds;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('/')]
class IndexController extends Controller
{
    #[Get('/', name: 'index')]
    public function index()
    {
        return Opds::response(
            app: OpdsConfig::app(),
            entries: OpdsConfig::home(),
        );
    }

    #[Get('/search', name: 'search')]
    public function search(Request $request)
    {
        $query = $request->input('q');
        $entries = [];

        if ($query) {
            $search = SearchEngine::make(q: $query, relevant: false, opds: true, types: ['books']);

            foreach ($search->results_opds as $result) {
                /** @var Book $result */
                $entries[] = OpdsConfig::bookToEntry($result);
            }
        }

        return Opds::response(
            app: OpdsConfig::app(),
            entries: $entries,
            title: "Search for {$query}",
            isSearch: true,
        );
    }
}
