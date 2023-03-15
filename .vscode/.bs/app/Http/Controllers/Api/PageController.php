<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Page\PageCollectionResource;
use App\Http\Resources\Page\PageResource;
use App\Models\Page;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('pages')]
class PageController extends ApiController
{
    #[Get('/', name: 'pages.index')]
    public function index()
    {
        $pages = Page::all();

        return PageCollectionResource::collection($pages);
    }

    #[Get('/{page_slug}', name: 'pages.show')]
    public function show(Page $page)
    {
        return PageResource::make($page);
    }
}
