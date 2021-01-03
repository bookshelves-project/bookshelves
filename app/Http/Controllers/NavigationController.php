<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Book;
use Inertia\Inertia;
use App\Http\Resources\BookResource;

class NavigationController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function dashboard()
    {
        $books = Book::all();
        $books = BookResource::collection($books);

        Inertia::share('books', $books);

        return Inertia::render('Dashboard');
    }

    public function download(string $slug)
    {
        $book = Book::whereSlug($slug)->firstOrFail();

        $path = str_replace('storage/', '', $book->path);

        return Storage::disk('public')->download($path);
    }
}
