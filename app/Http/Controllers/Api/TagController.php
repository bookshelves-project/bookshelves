<?php

namespace App\Http\Controllers\Api;

use Spatie\Tags\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagLightResource;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::whereType('tag')->orderBy('name->en')->get();

        return TagLightResource::collection($tags);
    }

    public function show(string $tag_slug)
    {
        $tag = Tag::where('slug->en', $tag_slug)->first();

        return TagResource::make($tag);
    }
}
