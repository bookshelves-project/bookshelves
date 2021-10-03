<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Providers\CommonMarkProvider;
use App\Utils\BookshelvesTools;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

/**
 * @hideFromAPIDocumentation
 */
class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $markdown = CommonMarkProvider::generate('catalog/content/index.md');
        $content = $markdown->content;

        $agent = new Agent();
        if ($agent->isDesktop()) {
            return view('pages.features.catalog.index', compact('content'));
        }

        return redirect(route('features.catalog.search'));
    }

    public function search(Request $request)
    {
        $searchTermRaw = $request->input('q');
        if ($searchTermRaw) {
            $collection = BookshelvesTools::searchGlobal($searchTermRaw);
            $authors = array_filter($collection, function ($item) {
                return 'author' == $item['meta']['entity'];
            });
            $authors = collect($authors);
            $series = array_filter($collection, function ($item) {
                return 'serie' == $item['meta']['entity'];
            });
            $series = collect($series);
            $books = array_filter($collection, function ($item) {
                return 'book' == $item['meta']['entity'];
            });
            $books = collect($books);

            return view('pages.features.catalog.search', compact('authors', 'series', 'books'));
        }

        return view('pages.features.catalog.search');
    }
}
