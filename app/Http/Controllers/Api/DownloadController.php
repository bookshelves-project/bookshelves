<?php

namespace App\Http\Controllers\Api;

use File;
use ZipArchive;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Support\MediaStream;

/**
 * @group Download
 */
class DownloadController extends Controller
{
    /**
     * @OA\Get(
     *     path="/download/book/{author}/{book}",
     *     tags={"download"},
     *     summary="Download specific book",
     *     description="Download specific book, check /books endpoint to get list of slugs",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Slug of author name like 'auel-jean-m' for Jean M. Auel",
     *         required=true,
     *         example="auel-jean-m",
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         description="Slug of book name like 'les-refuges-de-pierre' for Les refuges de pierre",
     *         required=true,
     *         example="les-refuges-de-pierre",
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function book(Request $request, string $author, string $book)
    {
        $book = Book::whereSlug($book)->firstOrFail();
        if ($book->meta_author === $author) {
            $epub = $book->getMedia('epubs')->first();
        } else {
            return response()->json(['Error' => 'Book not found'], 401);
        }

        return response()->download($epub->getPath(), $epub->file_name);
    }

    /**
     * @OA\Get(
     *     path="/download/serie/{author}/{serie}",
     *     tags={"download"},
     *     summary="Download specific serie's books with ZIP",
     *     description="Download specific serie, check /series endpoint to get list of slugs",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Slug of author name like 'auel-jean-m' for Jean M. Auel",
     *         required=true,
     *         example="auel-jean-m",
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         description="Slug of book name like 'les-enfants-de-la-terre' for Les enfants de la terre",
     *         required=true,
     *         example="les-enfants-de-la-terre",
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function serie(string $author, string $serie)
    {
        $epubs = [];
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::with('books')->whereSlug($serie)->firstOrFail();
        $authorFound = false;
        foreach ($serie->authors as $key => $authorList) {
            if ($author->slug === $authorList->slug) {
                $authorFound = true;
            }
        }
        if (! $authorFound) {
            return response(['error' => 'Not found'], 404);
        }

        foreach ($serie->books as $key => $book) {
            $epub = $book->getMedia('epubs')->first();
            array_push($epubs, $epub);
        }

        $token = Str::random(8);
        $token = strtolower($token);
        $author = $serie->meta_author;
        $dirname = "$author-$serie->slug-$token";

        return MediaStream::create("$dirname.zip")->addMedia($epubs);
    }

    /**
     * @OA\Get(
     *     path="/download/author/{author}",
     *     tags={"download"},
     *     summary="Download specific author's books with ZIP",
     *     description="Download specific author, check /authors endpoint to get list of slugs",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Slug of author name like 'auel-jean-m' for Jean M. Auel",
     *         required=true,
     *         example="auel-jean-m",
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     * 		   @OA\JsonContent(),
     *     )
     * )
     */
    public function author(string $author)
    {
        $epubs = [];
        $author = Author::with('books')->whereSlug($author)->firstOrFail();
        foreach ($author->books as $key => $book) {
            $epub = $book->getMedia('epubs')->first();
            array_push($epubs, $epub);
        }

        $token = Str::random(8);
        $token = strtolower($token);
        $dirname = "$author->slug-$token";

        return MediaStream::create("$dirname.zip")->addMedia($epubs);
    }

    /**
     * Old download method.
     */
    public function getZip(string $model_name, string $slug)
    {
        $modelName = '\App\Models'.'\\'.$model_name;
        $model = $modelName::with('books')->whereSlug($slug)->firstOrFail();

        try {
            $token = Str::random(8);
            $token = strtolower($token);
            $dirname = "$model->slug-$token";
            $path = public_path("storage/$dirname");
            if (! File::exists($path)) {
                File::makeDirectory($path);
            }

            $downloadList = [];
            foreach ($model->books->toArray() as $key => $book) {
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

            return public_path("storage/$dirname.zip");
        } catch (\Throwable $th) {
            return response()->json('Unexpected error!');
        }
    }
}
