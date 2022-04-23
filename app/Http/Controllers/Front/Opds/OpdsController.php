<?php

namespace App\Http\Controllers\Front\Opds;

use App\Engines\OpdsEngine;
use App\Http\Controllers\Controller;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('opds')]
class OpdsController extends Controller
{
    #[Get('/', name: 'front.opds')]
    public function index(Request $request)
    {
        SEOTools::setTitle('OPDS');

        $service = MarkdownService::generate('opds/index.md');
        $content = $service->convertToHtml();

        $feeds = [
            [
                'title' => 'Version 1.2',
                'param' => '1.2',
            ],
        ];
        $latest_feed = $feeds[sizeof($feeds) - 1];
        $latest_feed = route('front.opds', ['version' => $latest_feed['param']]);

        if ($engine = OpdsEngine::create($request)) {
            return $engine->index();
        }

        return view('front::pages.opds.index', compact('content', 'feeds', 'latest_feed'));
    }

    #[Get('/search', name: 'front.opds.search')]
    public function search(Request $request)
    {
        $engine = OpdsEngine::create($request);

        return $engine->search();
    }
}
