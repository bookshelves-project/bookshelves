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
        $perPage = $request->get('perPage');
        $all = $request->get('all');
        if (null === $perPage) {
            $perPage = 32;
        }

        $cachedSeries = Cache::get('series');
        if (! $cachedSeries) {
            $series = Serie::with('books')->orderBy('title_sort')->get();

            Cache::remember('series', 120, function () use ($series) {
                return $series;
            });
        } else {
            $series = $cachedSeries;
        }

        if (! $all) {
            $series = $series->paginate($perPage);
        }
        $series = SerieLightResource::collection($series);

        return $series;
    }

    public function count()
    {
        return Serie::count();
    }

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
}
