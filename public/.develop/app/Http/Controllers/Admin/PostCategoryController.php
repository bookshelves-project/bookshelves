<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostCategoryResource;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('post-categories')]
class PostCategoryController extends Controller
{
    #[Get('fetch', name: 'post-categories.fetch')]
    public function fetch(Request $request)
    {
        return PostCategoryResource::collection(
            PostCategory::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->ordered()->withCount('posts')->get()
        );
    }
}
