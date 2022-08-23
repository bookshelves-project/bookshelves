<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Page;
use App\Models\Post;
use App\Models\Reference;
use App\Models\Service;
use Route;

class ApiController extends Controller
{
    public function __construct()
    {
        Route::bind('content_key', function ($slug) {
            return Content::where('key', $slug)->firstOrFail();
        });

        Route::bind('page_slug', function ($slug) {
            return Page::whereSlug($slug)->firstOrFail();
        });

        Route::bind('post_slug', function ($slug) {
            return Post::whereSlug($slug)->firstOrFail();
        });

        Route::bind('reference_slug', function ($slug) {
            return Reference::whereSlug($slug)->firstOrFail();
        });

        Route::bind('service_slug', function ($slug) {
            return Service::whereSlug($slug)->firstOrFail();
        });
    }
}
