<?php

namespace App\Http\Controllers\Api\Opds;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightestResource;
use App\Models\Book;
use App\Providers\Bookshelves\OpdsProvider;
use Illuminate\Http\Request;
use Response;

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

		$result = OpdsProvider::template();

		return response($result)->withHeaders([
			'Content-Type' => 'text/xml',
		]);
	}

	public function books()
	{
	}

	public function series()
	{
	}

	public function authors()
	{
	}
}
