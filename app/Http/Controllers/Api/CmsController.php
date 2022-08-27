<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Cms\Page\PageCollectionResource;
use App\Http\Resources\Cms\Page\PageResource;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group CMS
 *
 * APIs for CMS.
 */
#[Prefix('cms/pages')]
class CmsController extends ApiController
{
    /**
     * GET CMS[].
     *
     * Get all Pages ordered by `key`.
     *
     * @responseField data CMS[] List of pages.
     */
    #[Get('/', name: 'cms.pages.index')]
    public function index()
    {
        $pages = CmsPage::all();
        return PageCollectionResource::collection($pages);
    }

    /**
     * GET CMS[].
     *
     * Get all Pages ordered by `key`.
     *
     * @responseField data CMS[] List of pages.
     */
    #[Get('/{cms_page_slug}', name: 'cms.pages.show')]
    public function show(Request $request, CmsPage $page)
    {
        return PageResource::make($page);
    }
}
