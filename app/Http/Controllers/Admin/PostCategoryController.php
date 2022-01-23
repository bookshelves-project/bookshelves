<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function index(Request $request)
    {
        return PostResource::collection(
            PostCategory::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->ordered()->withCount('posts')->get()
        );
    }
}
