<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Spatie\Tags\Tag;
use App\Models\Author;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Tag\TagLightResource;
use App\Http\Resources\Tag\TagResource;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Tag::whereType('genre')->orderBy('name->en')->get();

        return TagLightResource::collection($genres);
    }

    public function show(string $genre)
    {
        $genre = Tag::where('slug->en', $genre)->first();

        return TagResource::make($genre);
    }
}
