<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        Route::bind('book_slug', fn (string $slug) => \App\Models\Book::query()->where('slug', $slug)->firstOrFail());
        Route::bind('author_slug', fn (string $slug) => \App\Models\Author::query()->where('slug', $slug)->firstOrFail());
    }
}
