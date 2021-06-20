<?php

namespace App\Http\Controllers\Api\Opds;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Serie;
use App\Providers\Bookshelves\OpdsProvider;
use Illuminate\Http\Request;
use Route;

class SerieController extends Controller
{
	public function index(Request $request)
	{
		$series = Serie::orderBy('title_sort')->get();
		$result = OpdsProvider::template(data: $series, endpoint: 'serie', route: Route::currentRouteName());

		return response($result)->withHeaders([
			'Content-Type' => 'text/xml',
		]);
	}

	public function show(string $author_slug, string $serie_slug)
	{
		$author = Author::whereSlug($author_slug)->firstOrFail();
		$serie = $author->series->firstWhere('slug', $serie_slug);
		$route = route(Route::currentRouteName(), [
			'author' => $author_slug,
			'serie' => $serie_slug,
		]);
		$result = OpdsProvider::template(endpoint: 'serie', data: $serie, route: $route);

		return response($result)->withHeaders([
			'Content-Type' => 'text/xml',
		]);
	}
}
