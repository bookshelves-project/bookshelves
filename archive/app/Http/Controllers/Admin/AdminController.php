<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Index', [
            'books' => Book::paginate(32),
            'laravel' => Application::VERSION,
        ]);
    }
}
