<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/latest', name: 'api.series.latest')]
    public function latest()
    {
        $latest = Serie::with(['authors', 'media', 'language', 'library'])
            ->withCount(['books'])
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get();
        ray($latest);

        return response()->json(
            data: [
                'data' => $latest,
            ],
        );
    }
}
