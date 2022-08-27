<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\CmsPage;
use App\Models\Serie;
use Route;

class ApiController extends Controller
{
    public function __construct()
    {
        Route::bind('cms_page_slug', fn (string $param) => CmsPage::where('slug', $param)->firstOrFail());

        Route::bind('author_slug', fn (string $param) => Author::where('slug', $param)->firstOrFail());

        Route::bind('book_slug', fn (string $param) => Book::where('slug', $param)
            ->withCount('reviews')
            ->firstOrFail());

        Route::bind(
            'serie_slug',
            fn (string $param) => Serie::whereSlug($param)
                ->withCount('books')
                ->firstOrFail()
        );
    }
}
