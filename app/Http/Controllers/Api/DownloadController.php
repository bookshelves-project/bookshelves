<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use File;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\MediaStream;
use ZipArchive;

/**
 * @group Download
 *
 * Endpoint to download EPUB/ZIP.
 */
class DownloadController extends ApiController
{
    /**
     * GET Book EPUB.
     *
     * <small class="badge badge-green">Content-Type application/epub+zip</small>
     *
     * Download Book EPUB, find by slug of book and slug of author.
     *
     * @header Content-Type application/epub+zip
     */
    public function book(Author $author, Book $book)
    {
        // $book = Book::whereSlug($book)->firstOrFail();
        // if ($book->meta_author === $author) {
        $epub = $book->getMedia('epubs')->first();
        // } else {
        // return response()->json(['Error' => 'Book not found'], 401);
        // }

        return response()->download($epub->getPath(), $epub->file_name);
    }

    /**
     * GET Serie ZIP.
     *
     * <small class="badge badge-green">Content-Type application/octet-stream</small>
     *
     * Download Serie ZIP, find by slug of serie and slug of author.
     *
     * @header Content-Type application/octet-stream
     */
    public function serie(Author $author, Serie $serie)
    {
        $epubs = [];
        // $author = Author::whereSlug($author)->firstOrFail();
        // $serie = Serie::with('books')->whereSlug($serie)->firstOrFail();
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
        $dirname = "{$author}-{$serie->slug}-{$token}";

        return MediaStream::create("{$dirname}.zip")->addMedia($epubs);
    }

    /**
     * GET Author ZIP.
     *
     * <small class="badge badge-green">Content-Type application/octet-stream</small>
     *
     * Download Author ZIP, find by slug of author.
     *
     * @header Content-Type application/octet-stream
     */
    public function author(Author $author)
    {
        $epubs = [];
        // $author = Author::with('books')->whereSlug($author)->firstOrFail();
        foreach ($author->books as $key => $book) {
            $epub = $book->getMedia('epubs')->first();
            array_push($epubs, $epub);
        }

        $token = Str::random(8);
        $token = strtolower($token);
        $dirname = "{$author->slug}-{$token}";

        return MediaStream::create("{$dirname}.zip")->addMedia($epubs);
    }

    /**
     * @deprecated Old download method
     */
    public function getZip(string $model_name, string $slug)
    {
        $modelName = '\App\Models'.'\\'.$model_name;
        $model = $modelName::with('books')->whereSlug($slug)->firstOrFail();

        try {
            $token = Str::random(8);
            $token = strtolower($token);
            $dirname = "{$model->slug}-{$token}";
            $path = public_path("storage/{$dirname}");
            if (! File::exists($path)) {
                File::makeDirectory($path);
            }

            $downloadList = [];
            foreach ($model->books->toArray() as $key => $book) {
                $path = str_replace('storage/', '', $book['epub']['name']);
                array_push($downloadList, $path);
            }
            foreach ($downloadList as $key => $epub) {
                File::copy(public_path("storage/books/{$epub}"), public_path("storage/{$dirname}/{$epub}"));
            }

            $zip = new ZipArchive();
            $fileName = $dirname.'.zip';

            if (true === $zip->open(public_path('storage/'.$fileName), ZipArchive::CREATE)) {
                $files = File::files(public_path("storage/{$dirname}"));

                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }

                $zip->close();
            }

            File::deleteDirectory(public_path("storage/{$dirname}"));

            return public_path("storage/{$dirname}.zip");
        } catch (\Throwable $th) {
            return response()->json('Unexpected error!');
        }
    }
}
