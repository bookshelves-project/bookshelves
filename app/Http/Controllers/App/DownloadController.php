<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\DownloadBaseController;
use App\Models\Book;
use App\Models\Download;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('download')]
class DownloadController extends DownloadBaseController
{
    #[Get('/{book_id}', name: 'download.book')]
    public function book(Request $request, string $book_id)
    {
        /** @var Book */
        $book = Book::query()
            ->findOrFail($book_id);

        Download::generate($request, $book);

        return $this->downloadBook($book);
    }

    #[Get('/serie/{serie_id}', name: 'download.serie')]
    public function serie(Request $request, string $serie_id)
    {
        /** @var Serie */
        $serie = Serie::query()
            ->findOrFail($serie_id);

        Download::generate($request, $serie);

        return $this->downloadSerie($serie);
    }
}
