<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Page;
use App\Models\Post;
use App\Models\Serie;
use App\Models\TagExtend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Route;

class ApiController extends Controller
{
    public function __construct()
    {
        Route::bind('book_slug', fn (string $param) => Book::where('slug', $param)
            ->withCount('reviews')
            ->firstOrFail());

        Route::bind(
            'serie_slug',
            fn (string $param) => Serie::whereSlug($param)
                ->withCount('books')
                ->firstOrFail()
        );

        Route::bind('author_slug', fn (string $param) => Author::where('slug', $param)->firstOrFail());

        Route::bind('tag_slug', fn (string $param) => TagExtend::where('slug->en', $param)->firstOrFail());

        Route::bind('cms_page_slug', fn (string $param) => Page::where('slug', $param)->firstOrFail());

        Route::bind('post_slug', fn (string $param) => Post::where('slug', $param)->firstOrFail());
    }

    protected function getLang(Request $request)
    {
        $lang = $request->lang ? $request->lang : config('app.locale');
        App::setLocale($lang);
    }

    protected function getPaginationLimit(Request $request, int $default = 32): int
    {
        return $request->limit ? $request->limit : $default;
    }

    protected function getFull(Request $request): bool
    {
        return $request->boolean('full');
    }
}
