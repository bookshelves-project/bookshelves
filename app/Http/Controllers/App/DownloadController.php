<?php

namespace App\Http\Controllers\App;

use App\Enums\BookTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Audiobook;
use App\Models\Book;
use Illuminate\Http\Request;
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
        ray(file_exists($book->physical_path));

        return response()
            ->download($book->physical_path, "{$book->slug_sort}.{$book->extension}");

        if ($book->type !== BookTypeEnum::audiobook) {
            return response()
                ->download($book->physical_path, "{$book->slug_sort}.{$book->extension}");
            // Downloader::direct($book->physical_path)
            //     ->mimeType($book->mime_type)
            //     ->name("{$book->slug_sort}.{$book->extension}")
            //     ->get();
        }

        $audiobooks = $book->audiobooks;
        $files = $audiobooks
            ->map(fn (Audiobook $audiobook) => new DownloaderZipStreamItem($audiobook->basename, $audiobook->physical_path))
            ->toArray();

        Downloader::stream($audiobooks->first()->physical_path)
            ->files($files)
            ->get();
    }

    #[Get('/size/{book_id}', name: 'downloads.size')]
    public function size(Request $request, Book $book)
    {
        ray($book);
        // return $this->getQueryForBooks($request, Book::whereIsBook(), 'Books', [
        //     ['label' => 'Books', 'route' => ['name' => 'books.index']],
        // ]);
    }
}
