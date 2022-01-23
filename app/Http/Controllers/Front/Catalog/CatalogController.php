<?php

namespace App\Http\Controllers\Front\Catalog;

use App\Http\Controllers\Controller;
use App\Services\MarkdownService;
use App\Services\SearchEngineService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

/**
 * @hideFromAPIDocumentation
 */
class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $service = MarkdownService::generate('catalog/index.md');
        $content = $service->convertToHtml();

        SEOTools::setTitle('Catalog');
        SEOTools::setDescription('Get eBooks from your eReader');

        $agent = new Agent();
        if ($agent->isDesktop()) {
            return view('front::pages.catalog.index', compact('content'));
        }

        return redirect(route('front.catalog.search'));
    }

    public function search(Request $request)
    {
        // $q = $request->input('q');
        // if ($q) {
        //     $engine = SearchEngineService::create($q);

        //     $authors_relevant = $engine->authors_relevant;
        //     $series_relevant = $engine->series_relevant;
        //     $books_relevant = $engine->books_relevant;

        //     $authors_other = $engine->authors_other;
        //     $series_other = $engine->series_other;
        //     $books_other = $engine->books_other;

        //     return view('pages.features.catalog.search', compact(
        //         'authors_relevant',
        //         'series_relevant',
        //         'books_relevant',
        //         'authors_other',
        //         'series_other',
        //         'books_other'
        //     ));
        // }

        // return view('pages.features.catalog.search');
    }
}
