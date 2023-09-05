<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Page\PageCollection;
use App\Http\Resources\Page\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group CMS
 *
 * APIs for CMS.
 */
#[Prefix('cms/pages')]
class CmsController extends Controller
{
    /**
     * GET CMS[].
     *
     * Get all Pages ordered by `key`.
     *
     * @responseField data CMS[] List of pages.
     */
    #[Get('/', name: 'api.pages.index')]
    public function index()
    {
        $pages = Page::all();

        return PageCollection::collection($pages);
    }

    /**
     * GET CMS[].
     *
     * Get all Pages ordered by `key`.
     *
     * @responseField data CMS[] List of pages.
     */
    #[Get('/{cms_page_slug}', name: 'api.pages.show')]
    public function show(Request $request, Page $page)
    {
        return PageResource::make($page);
    }
}
