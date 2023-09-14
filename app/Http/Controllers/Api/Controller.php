<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Page;
use App\Models\Post;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    public function __construct()
    {
        Route::bind('book_slug',
            fn (string $param) => Book::query()
                ->where('slug', $param)
                ->withCount('reviews')
                ->firstOrFail());

        Route::bind(
            'serie_slug',
            fn (string $param) => Serie::query()
                ->whereSlug($param)
                ->with(['authors'])
                ->withCount('books')
                ->firstOrFail()
        );

        Route::bind('author_slug',
            fn (string $param) => Author::query()
                ->where('slug', $param)
                ->firstOrFail());

        Route::bind('tag_slug',
            fn (string $param) => TagExtend::query()
                ->where('slug->en', $param)
                ->firstOrFail());

        Route::bind('page_slug',
            fn (string $param) => Page::query()
                ->where('slug', $param)
                ->firstOrFail());

        Route::bind('post_slug',
            fn (string $param) => Post::query()
                ->where('slug', $param)
                ->firstOrFail());

        Route::bind('publisher_slug',
            fn (string $param) => Publisher::query()
                ->where('slug', $param)
                ->firstOrFail());
    }

    // protected function getLang(Request $request)
    // {
    //     $lang = $request->lang ? $request->lang : config('app.locale');
    //     App::setLocale($lang);
    // }

    // protected function getPaginationLimit(Request $request, int $default = 32): int
    // {
    //     return $request->limit ? $request->limit : $default;
    // }

    // protected function getFull(Request $request): bool
    // {
    //     return $request->boolean('full');
    // }

    // protected function getEntity(string $entity): string
    // {
    //     $model_name = ucfirst($entity);

    //     return "App\\Models\\{$model_name}";
    // }

    public function paginate(iterable $items, int $size = 15, int $page = 1, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $size), $items->count(), $size, $page, $options);
    }
}