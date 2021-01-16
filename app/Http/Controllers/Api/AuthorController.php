<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorCollection;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage');

        $authors = Author::with('books');
        if (null !== $perPage) {
            $authors = $authors->paginate($perPage);
        } else {
            $authors = $authors->get();
        }

        $authors = AuthorCollection::collection($authors);

        return $authors;
    }

    public function count()
    {
        return Author::count();
    }

    public function show(Request $request, string $author)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $author = AuthorResource::make($author);

        return $author;
    }
}
