<?php

namespace App\Http\Controllers\Api\Opds;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightestResource;
use App\Models\Book;
use DateTime;
use Illuminate\Http\Request;
use Response;
use Route;
use Spatie\ArrayToXml\ArrayToXml;

class OpdsController extends Controller
{
	public function index(Request $request)
	{
		return view('pages.api.opds.index');
	}

	public function feed(Request $request)
	{
		$books = Book::orderBy('title_sort')->limit(30)->get();
		$books = BookLightestResource::collection($books);
		$books = $books->toArray($request);

		$books_list = [];
		foreach ($books as $key => $book) {
			array_push($books_list, $book['title']);
		}

		$id = parse_url(config('app.url'))['host'];
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');

		$entries = [
			[
				'title' => 'Authors',
				'updated' => $date,
				'id' => "$id:authors",
				'content' => [
					'_attributes' => [
						'type' => 'text',
					],
				],
				'__custom:link:1' => [
					'_attributes' => [
						'href' => route(Route::currentRouteName()),
						'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					],
				],
				'__custom:link:2' => [
					'_attributes' => [
						'href' => 'image-path',
						'type' => 'image/png',
						'rel' => 'http://opds-spec.org/image/thumbnail',
					],
				],
			],
			[
				'title' => 'Series',
				'updated' => $date,
				'id' => "$id:series",
				'content' => [
					'_attributes' => [
						'type' => 'text',
					],
				],
				'__custom:link:1' => [
					'_attributes' => [
						'href' => route(Route::currentRouteName()),
						'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					],
				],
				'__custom:link:2' => [
					'_attributes' => [
						'href' => 'image-path',
						'type' => 'image/png',
						'rel' => 'http://opds-spec.org/image/thumbnail',
					],
				],
			],
			[
				'title' => 'Publishers',
				'updated' => $date,
				'id' => "$id:publishers",
				'content' => [
					'_attributes' => [
						'type' => 'text',
					],
				],
				'__custom:link:1' => [
					'_attributes' => [
						'href' => route(Route::currentRouteName()),
						'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					],
				],
				'__custom:link:2' => [
					'_attributes' => [
						'href' => 'image-path',
						'type' => 'image/png',
						'rel' => 'http://opds-spec.org/image/thumbnail',
					],
				],
			],
		];

		$xml = [
			'id' => "$id:catalog",
			'__custom:link:1' => [
				'_attributes' => [
					'rel' => 'self',
					'href' => route(Route::currentRouteName()),
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					'title' => 'Home',
				],
			],
			'__custom:link:2' => [
				'_attributes' => [
					'rel' => 'start',
					'href' => route('api.opds.1-2'),
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					'title' => 'Feed',
				],
			],
			'title' => config('app.name') . ' OPDS',
			'updated' => $date,
			'author' => [
				'name' => config('app.name'),
				'uri' => config('app.url'),
			],
			'entry' => $entries,
		];

		$result = ArrayToXml::convert($xml, [
			'rootElementName' => 'feed',
			'_attributes' => [
				'xmlns:app' => 'http://www.w3.org/2007/app',
				'xmlns:opds' => 'http://opds-spec.org/2010/catalog',
				'xmlns:opensearch' => 'http://a9.com/-/spec/opensearch/1.1/',
				'xmlns:odl' => 'http://opds-spec.org/odl',
				'xmlns:dcterms' => 'http://purl.org/dc/terms/',
				'xmlns' => 'http://www.w3.org/2005/Atom',
				'xmlns:thr' => 'http://purl.org/syndication/thread/1.0',
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
			],
		], true, 'UTF-8');

		return response($result)->withHeaders([
			'Content-Type' => 'text/xml',
		]);
	}
}
