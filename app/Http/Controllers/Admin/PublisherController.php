<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\PublisherQuery;
use App\Http\Resources\Admin\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('publishers')]
class PublisherController extends Controller
{
    #[Get('/', name: 'publishers')]
    public function index()
    {
        return app(PublisherQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('publishers/Index', $data))
        ;
    }

    #[Get('create', name: 'publishers.create')]
    public function create()
    {
        return Inertia::render('publishers/Create');
    }

    #[Get('{publisher}/edit', name: 'publishers.edit')]
    public function edit(Publisher $publisher)
    {
        return Inertia::render('publishers/Edit', [
            'publisher' => PublisherResource::make($publisher), // $stubVar->load('relation')
        ]);
    }

    #[Delete('{publisher}', name: 'publishers.destroy')]
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers')->with('flash.success', __('Publisher deleted.'));
    }

    #[Delete('/', name: 'publishers.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Publisher::query()->findMany($request->input('ids'))
            ->each(fn (Publisher $publisher) => $publisher->delete())
            ->count()
        ;

        return redirect()->route('admin.publishers')->with('flash.success', __(':count publishers deleted.', ['count' => $count]));
    }

    #[Get('fetch', name: 'publishers.fetch')]
    public function fetch(Request $request)
    {
        return PublisherResource::collection(
            Publisher::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->withCount('books')->get()
        );
    }
}
