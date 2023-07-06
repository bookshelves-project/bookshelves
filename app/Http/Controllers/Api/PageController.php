<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Page\PageCollection;
use App\Http\Resources\Page\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();

        return PageCollection::collection($pages);
    }

    public function show(Page $page)
    {
        return PageResource::make($page);
    }
}
