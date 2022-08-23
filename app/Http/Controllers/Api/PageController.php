<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Page\PageCollectionResource;
use App\Http\Resources\Page\PageResource;
use App\Models\Page;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Content
 *
 * APIs for Content.
 */
#[Prefix('pages')]
class PageController extends ApiController
{
    /**
     * GET Page[].
     *
     * Get all Pages ordered by `slug`.
     *
     * @responseField data Page[] List of pages.
     */
    #[Get('/', name: 'api.pages.index')]
    public function index()
    {
        $models = Page::orderBy('slug')->get();

        return PageCollectionResource::collection($models);
    }

    /**
     * GET Page.
     */
    #[Get('/{page_slug}', name: 'api.pages.show')]
    public function show(Page $page)
    {
        return PageResource::make($page);
    }
}
