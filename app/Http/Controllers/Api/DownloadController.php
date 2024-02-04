<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\Downloader\Downloader;
use Kiwilan\Steward\Utils\Downloader\DownloaderZipStreamItem;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('downloads')]
class DownloadController extends Controller
{
    #[Get('/book/{book_id}', name: 'api.downloads.book')]
    public function book(Request $request, Book $book)
    {
        $serie = $book->serie?->name ?? '';
        $volume = $book->volume ?? '';
        if ($serie) {
            $serie = Str::slug("{$serie}-{$volume}");
        }
        $author = $book->authorMain?->name ?? '';
        $name = Str::slug("{$serie}-{$book->slug}-{$author}-{$book->type->value}");

        if ($book->type !== BookTypeEnum::audiobook) {
            Downloader::direct($book->physical_path)
                ->mimeType($book->mime_type)
                ->name("{$name}.{$book->extension}")
                ->get();

            return;
        }

        $audiobooks = $book->audiobooks;
        $files = $audiobooks
            ->map(fn (Audiobook $audiobook) => new DownloaderZipStreamItem($audiobook->basename, $audiobook->physical_path))
            ->toArray();

        Downloader::stream($name)
            ->files($files)
            ->get();
    }

    #[Get('/serie/{serie_id}', name: 'api.downloads.serie')]
    public function serie(Request $request, Serie $serie)
    {
        $files = [];
        $serie->load('books');

        if ($serie->type !== BookTypeEnum::audiobook) {
            $files = $serie->books
                ->map(fn (Book $book) => new DownloaderZipStreamItem("{$book->slug}.{$book->extension}", $book->physical_path))
                ->toArray();
        } else {
            foreach ($serie->books as $book) {
                $book->load('audiobooks');
                $audiobooks = $book->audiobooks;
                $files = array_merge(
                    $files,
                    $audiobooks
                        ->map(function (Audiobook $audiobook) use ($book) {
                            $name = Str::slug("{$book->title}").'.'.$audiobook->basename;

                            return new DownloaderZipStreamItem($name, $audiobook->physical_path);
                        })
                        ->toArray()
                );
            }
        }

        $name = Str::slug("{$serie->slug}-".$serie->books->count().'-books');
        Downloader::stream($name)
            ->files($files)
            ->get();
    }
}
