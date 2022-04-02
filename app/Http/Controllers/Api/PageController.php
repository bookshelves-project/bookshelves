<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\PageQuery;
use App\Http\Resources\Api\Page\PageCollectionResource;
use App\Http\Resources\Api\Page\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Relation: Page
 *
 * Endpoint to get Pages data.
 */
#[Prefix('pages')]
class PageController extends ApiController
{
    /**
     * GET Page[].
     */
    #[Get('/', name: 'pages.index')]
    public function index(Request $request)
    {
        $this->getLang($request);

        return app(PageQuery::class)
            ->make(QueryOption::create(
                request: $request,
                resource: PageCollectionResource::class,
                orderBy: 'published_at',
                withExport: false,
                sortAsc: true,
                full: false,
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Page.
     */
    #[Get('/{page_slug}', name: 'pages.show')]
    public function show(Request $request, Page $Page)
    {
        $this->getLang($request);

        return PageResource::make($Page);
    }
}
