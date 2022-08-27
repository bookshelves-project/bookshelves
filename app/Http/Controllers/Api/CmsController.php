<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\PageResource;
use App\Models\Cms\Page;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group CMS
 *
 * APIs for CMS.
 */
#[Prefix('cms')]
class CmsController extends Controller
{
    /**
     * GET CMS[].
     *
     * Get all Pages ordered by `key`.
     *
     * @responseField data CMS[] List of pages.
     */
    #[Get('/', name: 'api.cms.index')]
    public function index()
    {
        $template = Page::whereSlug('home-page_en')->first();
        return PageResource::make($template);
    }
}
