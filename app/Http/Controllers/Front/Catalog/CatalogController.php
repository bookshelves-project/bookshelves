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
        $q = $request->input('q');
        if ($q) {
            $engine = SearchEngineService::create($q);

            $results = [
                'relevant' => [
                    'authors' => $engine->authors_relevant,
                    'series' => $engine->series_relevant,
                    'books' => $engine->books_relevant,
                ],
                'other' => [
                    'authors' => $engine->authors_other,
                    'series' => $engine->series_other,
                    'books' => $engine->books_other,
                ],
            ];

            return view('front.pages.catalog.search', compact(
                'q',
                'results',
            ));
        }

        return view('front.pages.catalog.search');
    }
}
