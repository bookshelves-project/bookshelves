<?php

namespace App\Http\Controllers\Api;

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
