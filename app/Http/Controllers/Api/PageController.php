<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Page\PageCollection;
use App\Http\Resources\Page\PageResource;
use App\Models\Page;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('pages')]
class PageController extends Controller
{
    #[Get('/', name: 'pages.index')]
    public function index()
    {
        $pages = Page::all();

        return PageCollection::collection($pages);
    }

    #[Get('/{page_slug}', name: 'pages.show')]
    public function show(Page $page)
    {
        return PageResource::make($page);
    }
}
