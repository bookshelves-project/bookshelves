<?php

namespace App\Http\Controllers\Api;

use Str;
use File;
use ZipArchive;
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

        $series = Serie::with('books')->get();

        $articles = [
            'The',
            'Les',
            "L'",
            'Le',
            'La',
        ];
        $series = $series->sortBy(function ($serie, $key) use ($articles) {
            $title = $serie->title;
            $title = str_replace($articles, '', $title);
            $title = stripAccents($title);

            // echo $title.'<br/>';

            return $title;
        });

        if ($debug) {
            foreach ($series as $serie) {
                echo $serie->title.'<br>';
            }
        }

        if (null !== $perPage) {
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

    public function download(string $serie)
    {
        $serie = Serie::with('books')->whereSlug($serie)->firstOrFail();

        $token = Str::random(8);
        $token = strtolower($token);
        $dirname = "$serie->slug-$token";
        $path = public_path("storage/$dirname");
        if (! File::exists($path)) {
            File::makeDirectory($path);
        }

        $downloadList = [];
        foreach ($serie->books->toArray() as $key => $book) {
            $path = str_replace('storage/', '', $book['epub']['name']);
            array_push($downloadList, $path);
        }
        foreach ($downloadList as $key => $epub) {
            File::copy(public_path("storage/books/$epub"), public_path("storage/$dirname/$epub"));
        }

        $zip = new ZipArchive();
        $fileName = $dirname.'.zip';

        if (true === $zip->open(public_path('storage/'.$fileName), ZipArchive::CREATE)) {
            $files = File::files(public_path("storage/$dirname"));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        File::deleteDirectory(public_path("storage/$dirname"));

        return response()->download(public_path("storage/$dirname.zip"))->deleteFileAfterSend(true);
    }
}
