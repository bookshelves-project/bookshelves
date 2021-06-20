<?php

namespace App\Http\Controllers\Api\Opds;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Providers\Bookshelves\OpdsProvider;
use Route;

class AuthorController extends Controller
{
	public function index()
	{
		$entities = Author::orderBy('lastname')->get();
		$result = OpdsProvider::template(endpoint: 'author', data: $entities, route: route(Route::currentRouteName()));

		return response($result)->withHeaders([
			'Content-Type' => 'text/xml',
		]);
	}

	public function show(string $author_slug)
	{
		$route = route(Route::currentRouteName(), [
			'author' => $author_slug,
		]);
		$author = Author::whereSlug($author_slug)->firstOrFail();
		$result = OpdsProvider::template(endpoint: 'author', data: $author, route: $route);

		return response($result)->withHeaders([
			'Content-Type' => 'text/xml',
		]);
	}
}
