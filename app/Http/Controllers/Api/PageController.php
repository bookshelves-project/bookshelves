<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Page\PageCollection;
use App\Http\Resources\Page\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        return PageCollection::collection(Page::all());
    }

    public function show(Page $page)
    {
        return PageResource::make($page);
    }
}
