<?php

namespace App\Http\Controllers\Api;

use File;
use Storage;
use ZipArchive;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class DownloadController extends Controller
{
    public function book(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        $ebook_path = str_replace('storage/', '', $book->epub->path);

        return Storage::disk('public')->download($ebook_path);
    }

    public function serie(string $serie)
    {
        $path_to_download = $this->getZip('Serie', $serie);

        return response()->download($path_to_download)->deleteFileAfterSend(true);
    }

    public function author(string $author)
    {
        $path_to_download = $this->getZip('Author', $author);

        return response()->download($path_to_download)->deleteFileAfterSend(true);
    }

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
