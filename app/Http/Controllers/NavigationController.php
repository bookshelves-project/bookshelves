<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use App\Http\Resources\Book\BookResource;

class NavigationController extends Controller
{
    public function welcome()
    {
        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;

        return view('welcome', compact('laravelVersion', 'phpVersion'));
    }

    public function dashboard()
    {
        $books = Book::all();
        $books = BookResource::collection($books);

        Inertia::share('books', $books);

        return Inertia::render('Dashboard');
    }
}
