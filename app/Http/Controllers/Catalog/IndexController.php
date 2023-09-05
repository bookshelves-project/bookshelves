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
class IndexController extends Controller
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
        $engine = SearchEngine::make(
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
