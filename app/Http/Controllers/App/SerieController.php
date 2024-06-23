<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Serie;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/{library:slug}/{serie:slug}', name: 'series.show')]
    public function show(Library $library, string $serie)
    {
        $serie = Serie::query()
            ->where('slug', $serie)
            ->withCount(['books'])
            ->firstOrFail();

        $serie->loadMissing([
            'books',
            'books.media',
            'books.serie',
            'books.language',
            'books.library',
            'authors',
            'media',
            'library',
            'tags',
            'language',
        ]);

        return inertia('Series/Show', [
            'serie' => $serie,
            'library' => $library,
            'square' => $library->type->isAudiobook(),
        ]);
    }
}
