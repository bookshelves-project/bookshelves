<?php

namespace App\Http\Controllers\Front\Catalog;

use Detection\MobileDetect;
use Illuminate\Http\Request;
use App\Engines\SearchEngine;
use App\Services\MarkdownService;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('features/catalog')]
class CatalogController extends Controller
{
    #[Get('/', name: 'front.catalog')]
    public function index(Request $request)
    {
        SEOTools::setTitle('Catalog');
        SEOTools::setDescription('Get eBooks from your eReader');

        $service = MarkdownService::generate('catalog/index.md');
        $content = $service->convertToHtml();

        $mobile = new MobileDetect();
        if (! $mobile->isMobile()) {
            return view('front::pages.catalog.index', compact('content'));
        }

        return redirect(route('front.catalog.search'));
    }

    #[Get('/search', name: 'front.catalog.search')]
    public function search(Request $request)
    {
        $q = $request->input('q');
        if ($q) {
            $engine = SearchEngine::create($q);

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
