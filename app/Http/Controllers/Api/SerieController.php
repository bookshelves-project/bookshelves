<?php

namespace App\Http\Controllers\Api;

use App\Models\Serie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SerieResource;
use App\Http\Resources\SerieCollection;

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
        $debug = $request->get('debug');
        $all = $request->get('all');
        $all = filter_var($all, FILTER_VALIDATE_BOOLEAN);

        if (null === $perPage) {
            $perPage = 32;
        }
        $series = Serie::with('books')->orderBy('title_sort')->get();

        if ($debug) {
            foreach ($series as $serie) {
                echo $serie->title.'<br>';
            }
            exit;
        }

        if (! $all) {
            $series = $series->paginate($perPage);
        }

        $series = SerieCollection::collection($series);

        return $series;
    }

    public function count()
    {
        return Serie::count();
    }

    public function show(Request $request, string $serie)
    {
        $serie = Serie::whereSlug($serie)->firstOrFail();
        $serie = SerieResource::make($serie);

        return $serie;
    }
}
