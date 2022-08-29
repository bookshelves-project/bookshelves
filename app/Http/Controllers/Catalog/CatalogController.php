<?php

namespace App\Http\Controllers\Front\Catalog;

use App\Engines\SearchEngine;
use App\Http\Controllers\Controller;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Detection\MobileDetect;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('catalog')]
class CatalogController extends Controller
{
    #[Get('/', name: 'catalog.index')]
    public function index(Request $request)
    {
        SEOTools::setTitle('Catalog');
        SEOTools::setDescription('Get books from your eReader');

        return redirect(route('catalog.search'));
    }

    #[Get('/search', name: 'catalog.search')]
    public function search(Request $request)
    {
        $q = $request->input('q');
        $engine = SearchEngine::create(
            q: $q,
            relevant: true,
        );
        $results = $engine->results;

        return view('front.pages.catalog.search', compact(
            'q',
            'results',
        ));
    }
}
