<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Publisher\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('publishers')]
class PublisherController extends Controller
{
    /**
     * GET Publisher[].
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Publishers ordered by 'name'.
     *
     * @queryParam size int Entities per page, '32' by default. No-example
     * @queryParam full boolean Disable pagination. No-example
     * @queryParam page int The page number, '1' by default. No-example
     */
    #[Get('/', name: 'api.publishers.index')]
    public function index(Request $request)
    {
        // if ($alpha = $this->chunkByAlpha($request, Publisher::class, PublisherLightResource::class)) {
        //     return $alpha;
        // }

        // return app(PublisherQuery::class)
        //     ->make(QueryOption::create(
        //         request: $request,
        //         resource: PublisherLightResource::class,
        //         orderBy: 'name',
        //         withExport: false,
        //         sortAsc: true,
        //         full: $this->getFull($request)
        //     ))
        //     ->paginateOrExport()
        // ;

        return HttpQuery::for(Publisher::class, $request)
            ->collection()
        ;
    }

    /**
     * GET Publisher.
     *
     * Details for one Publisher, find by slug.
     */
    #[Get('/{publisher_slug}', name: 'api.publishers.show')]
    public function show(Publisher $publisher)
    {
        return PublisherResource::make($publisher);
    }

    /**
     * GET Book[] belongs to Publisher.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books of selected Publisher ordered by Books' 'title'.
     *
     * @queryParam size int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     */
    #[Get('/{publisher_slug}/books', name: 'api.publishers.books')]
    public function books(Request $request, Publisher $publisher)
    {
        $page = $request->get('size') ? $request->get('size') : 32;

        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'size' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        // $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();
        $books = $publisher->books()->paginate($page);

        return BookCollection::collection($books);
    }
}
