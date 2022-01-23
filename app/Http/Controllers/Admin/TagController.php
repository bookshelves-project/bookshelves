<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagResource;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class TagController extends Controller
{
    public function index(Request $request)
    {
        return TagResource::collection(
            Tag::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->ordered()->get()
        );
    }
}
