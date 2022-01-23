<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagResource;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\Tags\Tag;

#[Prefix('tags')]
class TagController extends Controller
{
    #[Get('/', name: 'tags')]
    public function index(Request $request)
    {
        return TagResource::collection(
            Tag::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->ordered()->get()
        );
    }
}
