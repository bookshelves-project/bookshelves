<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Publisher\PublisherLightResource;
use App\Http\Resources\Publisher\PublisherResource;
use App\Models\Publisher;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Publisher
 *
 * Endpoint to get Publishers data.
 */
class PublisherController extends Controller
{
    /**
     * GET Publisher collection.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Publishers ordered by 'name'.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     *
     * @responseFile public/assets/responses/publishers.index.get.json
     */
    public function index(Request $request)
    {
        $page = $request->get('per-page') ? $request->get('per-page') : null;

        // $pubs = Publisher::orderBy('name')->get();

        // if ($page) {
        //     if (! is_numeric($page)) {
        //         return response()->json(
        //             "Invalid 'per-page' query parameter, must be an int",
        //             400
        //         );
        //     }
        //     $page = intval($page);
        //     $pubs = $pubs->paginate($page);
        // }

        // return PublisherLightResource::collection($pubs);

        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Publisher::class, withCount: ['books'])
            ->allowedFilters([
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
     *
     * @urlParam slug string required The slug of author like 'bragelonne'. Example: bragelonne
     *
     * @responseFile public/assets/responses/publishers.show.get.json
     */
    public function show(string $publisher_slug)
    {
        $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();

        return PublisherResource::make($pub);
    }

    /**
     * GET Books collection of Publisher.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books of selected Publisher ordered by Books' 'title'.
     *
     * @urlParam publisher_slug string required The slug of author like 'bragelonne'. Example: bragelonne
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     *
     * @responseFile public/assets/responses/publishers.books.get.json
     */
    public function books(Request $request, string $publisher_slug)
    {
        $page = $request->get('per-page') ? $request->get('per-page') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();
        $books = $pub->books->paginate($page);

        return BookLightResource::collection($books);
    }
}
