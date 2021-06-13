<?php

namespace App\Http\Controllers\Api\Opds;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Models\Book;
use Illuminate\Http\Request;

class OpdsController extends Controller
{
	public function index(Request $request)
	{
		return view('pages.api.opds.index');
	}

	public function feed(Request $request)
	{
		$books = Book::orderBy('title_sort')->paginate(32);
		$books = BookLightResource::collection($books);

		return response()->xml($books);
	}
}
