<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return Inertia::render('Auth/Login', [
            'books' => Book::paginate(32),
            'laravel' => Application::VERSION,
        ]);
    }
}
