<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Author\AuthorLightResource;

class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/authors",
     *     tags={"authors"},
     *     summary="List of authors",
     *     description="Authors",
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Integer to choose how many books you show in each page",
     *         required=false,
     *         example=32,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage');
        $all = $request->get('all');
        if (null === $perPage) {
            $perPage = 32;
        }

        $cachedAuthors = Cache::get('authors');

        if (! $cachedAuthors) {
            $authors = Author::with('books')->orderBy('lastname')->get();

            Cache::remember('authors', 120, function () use ($authors) {
                return $authors;
            });
        } else {
            $authors = $cachedAuthors;
        }

        if (! $all) {
            $authors = $authors->paginate($perPage);
        }
        $authors = AuthorLightResource::collection($authors);

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
