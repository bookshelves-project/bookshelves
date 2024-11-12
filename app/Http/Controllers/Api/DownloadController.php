<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\DownloadBaseController;
use App\Models\Book;
use App\Models\Download;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\Downloader\Downloader;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('download')]
class DownloadController extends DownloadBaseController
{
    #[Get('/book/{book:id}', name: 'api.download.book')]
    public function book(Request $request, Book $book)
    {
        $name = '';
        $serie = $book->serie?->name ?? '';
        $volume = $book->volume ?? '';
        if ($serie) {
            $serie = Str::slug("{$serie}-{$volume}");
            $name = $serie;
        }
        $author = $book->authorMain?->name ?? '';

        Download::generate($request, $book);

        $name = Str::slug("{$name} {$book->slug} {$author}");

        Downloader::direct($book->file->path)
            ->mimeType($book->file->mime_type)
            ->name("{$name}.{$book->file->extension}")
            ->get();
    }

    #[Get('/{type}/{id}', name: 'api.download.save')]
    public function save(Request $request, string $type, string $id): void
    {
        $model = null;

        if ($type === 'book') {
            /** @var Book */
            $model = Book::query()->findOrFail($id);
        } elseif ($type === 'serie') {
            /** @var Serie */
            $model = Serie::query()->findOrFail($id);
        } else {
            abort(404);
        }

        Download::generate($request, $model);
    }
}
