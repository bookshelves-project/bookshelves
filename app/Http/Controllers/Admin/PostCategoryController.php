<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('post-categories')]
class PostCategoryController extends Controller
{
    #[Get('/', name: 'post-categories')]
    public function index(Request $request)
    {
        return PostResource::collection(
            PostCategory::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->ordered()->withCount('posts')->get()
        );
    }
}
