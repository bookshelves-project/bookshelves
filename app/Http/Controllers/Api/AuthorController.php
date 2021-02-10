<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorCollection;

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
        $all = filter_var($all, FILTER_VALIDATE_BOOLEAN);

        if (null === $perPage) {
            $perPage = 32;
        }
        $authors = Author::with('books')->get();
        if (! $all) {
            $authors = $authors->paginate($perPage);
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
