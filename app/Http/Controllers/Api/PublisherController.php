<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Publisher\PublisherLightResource;
use App\Http\Resources\Publisher\PublisherResource;
use App\Models\Publisher;

class PublisherController extends Controller
{
	public function index()
	{
		$pubs = Publisher::orderBy('name')->get();

		return PublisherLightResource::collection($pubs);
	}

	public function show(string $publisher_slug)
	{
		$pub = Publisher::whereSlug($publisher_slug)->first();

		return PublisherResource::make($pub);
	}

	public function showLight(string $publisher_slug)
	{
		$pub = Publisher::whereSlug($publisher_slug)->first();

		return PublisherLightResource::make($pub);
	}

	public function showBooks(string $publisher_slug)
	{
		$pub = Publisher::whereSlug($publisher_slug)->first();
		$books = $pub->books;

		return BookLightResource::collection($books);
	}
}
