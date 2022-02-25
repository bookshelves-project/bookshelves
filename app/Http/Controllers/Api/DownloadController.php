<?php

namespace App\Http\Controllers\Api;

use File;
use ZipArchive;
use Illuminate\Support\Str;

/**
 * @hideFromAPIDocumentation
 *
 * Endpoint to download EPUB/ZIP.
 */
class DownloadController extends ApiController
{
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
