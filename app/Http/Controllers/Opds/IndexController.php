<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsConfig;
use App\Engines\OpdsEngine;
use App\Engines\SearchEngine;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('/')]
class IndexController extends Controller
{
    #[Get('/', name: 'index')]
    public function index()
    {
        $module = OpdsEngine::make(
            app: OpdsConfig::app(),
            entries: OpdsConfig::home(),
        );

        return $module->response();
    }

    #[Get('/search', name: 'search')]
    public function search(Request $request)
    {
        $query = $request->input('q');
        $search = SearchEngine::make(q: $query, relevant: false, opds: true, types: ['books']);

        $entries = [];

        foreach ($search->results_opds as $result) {
            /** @var Book $result */
            $entries[] = OpdsConfig::bookToEntry($result);
        }

        $module = OpdsEngine::make(
            app: OpdsConfig::app(),
            entries: $entries,
            title: "Search for {$query}",
        );

        return $module->search();
    }
}
