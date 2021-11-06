<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Services\CommonMarkService;
use App\Services\SearchEngineService;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

/**
 * @hideFromAPIDocumentation
 */
class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $markdown = CommonMarkService::generate('catalog/content/index.md');
        $content = $markdown->content;

        $agent = new Agent();
        if ($agent->isDesktop()) {
            return view('pages.features.catalog.index', compact('content'));
        }

        return redirect(route('features.catalog.search'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        if ($q) {
            $engine = SearchEngineService::create($q);

            $authors_relevant = $engine->authors_relevant;
            $series_relevant = $engine->series_relevant;
            $books_relevant = $engine->books_relevant;

            $authors_other = $engine->authors_other;
            $series_other = $engine->series_other;
            $books_other = $engine->books_other;

            return view('pages.features.catalog.search', compact(
                'authors_relevant',
                'series_relevant',
                'books_relevant',
                'authors_other',
                'series_other',
                'books_other'
            ));
        }

        return view('pages.features.catalog.search');
    }
}
