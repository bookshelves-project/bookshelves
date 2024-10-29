<?php

namespace App\Http\Controllers\App;

use App\Enums\LibraryTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('libraries')]
class SerieController extends Controller
{
    #[Get('/{library:slug}/series', name: 'series.index')]
    public function index(Request $request, Library $library)
    {
        return inertia('Books/Index', [
            'library' => $library,
            'title' => $library->name,
            'query' => HttpQuery::for(
                Serie::with(['media', 'authors', 'library', 'language'])
                    ->withCount('books')
                    ->whereLibraryIs($library),
                $request,
            )->inertia(),
            'breadcrumbs' => [
                ['label' => $library->name, 'route' => ['name' => 'libraries.show', 'params' => ['library' => $library->slug]]],
            ],
            'square' => $library->type == LibraryTypeEnum::audiobook,
            'series' => true,
        ]);
    }

    #[Get('/{library:slug}/series/{serie:slug}', name: 'series.show')]
    public function show(Library $library, string $serie)
    {
        $serie = Serie::query()
            ->where('library_id', $library->id)
            ->where('slug', $serie)
            ->withCount(['books'])
            ->firstOrFail();

        $serie->append('format_icon');
        $serie->loadMissing([
            'books',
            'books.media',
            'books.serie',
            'books.language',
            'books.library',
            'books.authors',
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

    #[Get('/{library:slug}/series/{serie:slug}/cover', name: 'series.cover')]
    public function cover(Library $library, Serie $serie)
    {
        $serie->loadMissing([
            'media',
        ]);

        $path = $serie->cover_path;

        return response()->file($path, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }
}
