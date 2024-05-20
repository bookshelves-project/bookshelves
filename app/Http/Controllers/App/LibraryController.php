<?php

namespace App\Http\Controllers\App;

use App\Enums\LibraryTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;

class LibraryController extends Controller
{
    #[Get('/libraries', name: 'libraries.index')]
    public function index()
    {
        return redirect()->route('home');
    }

    #[Get('/libraries/{library:slug}', name: 'libraries.show')]
    public function show(Request $request, Library $library)
    {
        return inertia('Books/Index', [
            'library' => $library,
            'title' => $library->name,
            'query' => HttpQuery::for(
                Book::with(['media', 'authors', 'serie', 'library', 'language'])->whereLibraryIs($library),
                $request,
            )->inertia(),
            'breadcrumbs' => [
                ['label' => $library->name, 'route' => ['name' => 'libraries.show', 'params' => ['library' => $library->slug]]],
            ],
            'square' => $library->type == LibraryTypeEnum::audiobook,
            'series' => false,
        ]);
    }

    #[Get('/libraries/{library:slug}/series', name: 'libraries.series')]
    public function series(Request $request, Library $library)
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
}
