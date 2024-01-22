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
        // Route::bind('tv_show_slug', fn (string $id) => \App\Models\TvShow::query()->where('slug', $id)->firstOrFail());
        // Route::bind('genre_slug', fn (string $id) => \App\Models\Genre::query()->where('slug', $id)->firstOrFail());
        // Route::bind('collection_tmdb_id', fn (string $id) => \App\Models\Collection::query()->where('tmdb_id', $id)->firstOrFail());
        // Route::bind('network_tmdb_id', fn (string $id) => \App\Models\Network::query()->where('tmdb_id', $id)->firstOrFail());
        // Route::bind('member_tmdb_id', fn (string $id) => \App\Models\Member::query()->where('tmdb_id', $id)->firstOrFail());
    }
}
