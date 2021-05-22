<?php

namespace App\Http\Controllers\Api;

use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Serie\SerieResource;
use App\Http\Resources\Serie\SerieLightResource;

class SerieController extends Controller
{
    /**
     * @OA\Get(
     *     path="/series",
     *     tags={"series"},
     *     summary="List of series",
     *     description="Series",
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
        $perPage = $request->get('per-page');
        $perPage = $perPage ? $perPage : 32;
        if (! is_numeric($perPage)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $perPage = intval($perPage);

        $limit = $request->get('limit');
        $limit = $limit ? $limit : 'pagination';
        $limitParameters = ['pagination', 'all', 'full'];
        if (! in_array($limit, $limitParameters)) {
            return response()->json(
                "Invalid 'limit' query parameter, must be like '" . implode("' or '", $limitParameters) . "'",
                400
            );
        }

        $cachedSeries = Cache::get('series');
        if (! $cachedSeries) {
            $series = Serie::with('books')->orderBy('title_sort')->get();

            Cache::remember('series', 86400, function () use ($series) {
                return $series;
            });
        } else {
            $series = $cachedSeries;
        }

        switch ($limit) {
            case 'pagination':
                $series = $series->paginate($perPage);
                $series = SerieLightResource::collection($series);

                break;

            case 'full':
                $series = SerieLightResource::collection($series);

                break;

            default:
                $series = $series->paginate($perPage);
                $series = SerieLightResource::collection($series);

                break;
        }

        return $series;
    }

    /**
     * @OA\Get(
     *     path="/series/{author-slug}/{series-slug}",
     *     summary="Show series by author slug and by series slug",
     *     tags={"series"},
     *     description="Get details for a single series with list of books, check /series endpoint to get list of slugs",
     *     operationId="findAuthorByAuthorSlug",
     *     @OA\Parameter(
     *         name="author-slug",
     *         in="path",
     *         description="Slug of author name like 'auel-jean-m' for Jean M. Auel",
     *         required=true,
     *         example="auel-jean-m",
     *         @OA\Schema(
     *           type="string",
     *           @OA\Items(type="string"),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="series-slug",
     *         in="path",
     *         description="Slug of series name like 'les-enfants-de-la-terre' for Les enfants de la terre",
     *         required=true,
     *         example="les-enfants-de-la-terre",
     *         @OA\Schema(
     *           type="string",
     *           @OA\Items(type="string"),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Invalid author-slug value or book-slug value",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * )
     */
    public function show(Request $request, string $author, string $serie)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereSlug($serie)->firstOrFail();

        $authorFound = false;
        foreach ($serie->authors as $key => $authorList) {
            if ($author->slug === $authorList->slug) {
                $authorFound = true;
            }
        }
        if (! $authorFound) {
            return response(['error' => 'Not found'], 404);
        }

        $serie = SerieResource::make($serie);

        return $serie;
    }

    /**
     * @OA\Get(
     *     path="/series/count",
     *     tags={"series"},
     *     summary="Count for series",
     *     description="Count series",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function count()
    {
        return Serie::count();
    }
}
