<?php

namespace App\Http\Controllers\Api;

use Str;
use File;
use ZipArchive;
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

    public function download(string $author)
    {
        $author = Author::with('books')->whereSlug($author)->firstOrFail();

        $token = Str::random(8);
        $token = strtolower($token);
        $dirname = "$author->slug-$token";
        $path = public_path("storage/$dirname");
        if (! File::exists($path)) {
            File::makeDirectory($path);
        }

        $downloadList = [];
        foreach ($author->books->toArray() as $key => $book) {
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
