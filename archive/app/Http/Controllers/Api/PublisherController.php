<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Publisher\PublisherLightResource;
use App\Http\Resources\Publisher\PublisherResource;
use App\Models\Publisher;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Publisher
 *
 * Endpoint to get Publishers data.
 */
class PublisherController extends ApiController
{
    /**
     * GET Publisher collection.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Publishers ordered by 'name'.
     *
     * @queryParam perPage int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     */
    public function index(Request $request)
    {
        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Publisher::class, withCount: ['books'])
            ->allowedFilters([
                AllowedFilter::scope('negligible', 'whereIsNegligible'),
            ])
            ->allowedSorts([
                'id',
                'name',
            ])
            ->defaultSort('name')
        ;

        return QueryExporter::create($query)
            ->resource(PublisherLightResource::class)
            ->get()
        ;
    }

    /**
     * GET Publisher resource.
     *
     * Details for one Publisher, find by slug.
     */
    public function show(Publisher $publisher)
    {
        return PublisherResource::make($publisher);
    }

    /**
     * GET Books collection of Publisher.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books of selected Publisher ordered by Books' 'title'.
     *
     * @queryParam perPage int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     */
    public function books(Request $request, Publisher $publisher)
    {
        $page = $request->get('perPage') ? $request->get('perPage') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'perPage' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        // $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();
        $books = $publisher->books->paginate($page);

        return BookLightResource::collection($books);
    }
}
