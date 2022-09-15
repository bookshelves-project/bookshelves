<?php

namespace App\Http\Controllers\Catalog;

use App\Engines\SearchEngine;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * @hideFromAPIDocumentation
 */
class CatalogController extends Controller
{
    #[Get('/', name: 'index')]
    public function index(Request $request)
    {
        SEOTools::setTitle('Catalog');
        SEOTools::setDescription('Get books from your eReader');

        return redirect(route('catalog.search'));
    }

    #[Get('/search', name: 'search')]
    public function search(Request $request)
    {
        $q = $request->input('q');
        $engine = SearchEngine::create(
            q: $q,
            relevant: true,
        );
        $results = $engine->results;

        // catalog::pages.catalog.search
        return view('catalog::pages.index', compact(
            'q',
            'results',
        ));
    }
}
