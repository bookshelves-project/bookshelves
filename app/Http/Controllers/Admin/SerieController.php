<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\SerieQuery;
use App\Http\Resources\Admin\SerieResource;
use App\Models\Serie;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/', name: 'series')]
    public function index()
    {
        return app(SerieQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('series/Index', $data))
        ;
    }

    #[Get('create', name: 'series.create')]
    public function create()
    {
        return Inertia::render('series/Create');
    }

    #[Get('{serie}', name: 'series.show')]
    public function show()
    {
        return app(SerieQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('series/Index', $data))
        ;
    }

    #[Get('{serie}/edit', name: 'series.edit')]
    public function edit(Serie $serie)
    {
        return Inertia::render('series/Edit', [
            'serie' => SerieResource::make($serie->load('authors', 'books', 'media')),
        ]);
    }

    #[Delete('{serie}', name: 'series.destroy')]
    public function destroy(Serie $serie)
    {
        $serie->delete();

        return redirect()->route('admin.series')->with('flash.success', __('Serie deleted.'));
    }

    #[Delete('/', name: 'series.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Serie::query()->findMany($request->input('ids'))
            ->each(fn (Serie $serie) => $serie->delete())
            ->count()
        ;

        return redirect()->route('admin.series')->with('flash.success', __(':count series deleted.', ['count' => $count]));
    }
}
