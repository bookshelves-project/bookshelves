<?php

namespace App\Http\Controllers\App;

use App\Enums\BookTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Audiobook;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\Downloader\Downloader;
use Kiwilan\Steward\Utils\Downloader\DownloaderZipStreamItem;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('downloads')]
class DownloadController extends Controller
{
    #[Get('/{book_id}', name: 'downloads.show')]
    public function show(Request $request, Book $book)
    {
        /** @var ?BookTypeEnum $type */
        $type = $book->type;

        $serie = $book->serie?->name ?? '';
        $volume = $book->volume ?? '';
        if ($serie) {
            $serie = Str::slug("{$serie}-{$volume}");
        }
        $author = $book->authorMain?->name ?? '';
        $name = Str::slug("{$serie}-{$book->slug}-{$author}-{$type->value}");

        ray($book->type);
        ray(BookTypeEnum::audiobook);
        if ($type !== BookTypeEnum::audiobook) {
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

    #[Get('/size/{book_id}', name: 'downloads.size')]
    public function size(Request $request, Book $book)
    {
        /** @var ?BookTypeEnum $type */
        $type = $book->type;

        if ($type !== BookTypeEnum::audiobook) {
            $size = filesize($book->physical_path);
        } else {
            $audiobooks = $book->audiobooks;
            $size = $audiobooks
                ->map(fn (Audiobook $audiobook) => filesize($audiobook->physical_path))
                ->sum();
        }

        return response()->json([
            'extension' => $type === BookTypeEnum::audiobook ? 'zip' : $book->extension,
            'size' => $size,
        ]);
    }
}
