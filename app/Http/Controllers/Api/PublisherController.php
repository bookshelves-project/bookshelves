<?php

namespace App\Http\Controllers\Api;

use App\Models\Publisher;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Publisher\PublisherResource;
use App\Http\Resources\Publisher\PublisherLightResource;

class PublisherController extends Controller
{
    public function index()
    {
        $pubs = Publisher::orderBy('name')->get();

        return PublisherLightResource::collection($pubs);
    }

    public function show(string $publisher_slug)
    {
        $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();

        return PublisherResource::make($pub);
    }

    public function books(string $publisher_slug)
    {
        $pub = Publisher::whereSlug($publisher_slug)->firstOrFail();
        $books = $pub->books->paginate(32);

        return BookLightResource::collection($books);
    }
}
