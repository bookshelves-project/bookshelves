<?php

namespace App\Http\Controllers\Api;

use App\Models\Publisher;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Publisher\PublisherResource;
use App\Http\Resources\Publisher\PublisherLightResource;

/**
 * @group Publisher
 */
class PublisherController extends Controller
{
    /**
    * GET Publisher collection
    *
    * Get all publishers.
    *
    * @response {
    *  "id": 4,
    *  "name": "Jessica Jones",
    *  "roles": ["admin"]
    * }
    */
    public function index()
    {
        $pubs = Publisher::orderBy('name')->get();

        return PublisherLightResource::collection($pubs);
    }

    /**
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
     */
    public function show(string $publisher_slug)
    {
        $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();

        return PublisherResource::make($pub);
    }

    /**
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
     */
    public function books(string $publisher_slug)
    {
        $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();
        $books = $pub->books->paginate(32);

        return BookLightResource::collection($books);
    }
}
