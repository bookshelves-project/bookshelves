<?php

namespace App\Http\Controllers;

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
}
