<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\WikipediaItemQuery;
use App\Http\Requests\Admin\WikipediaItemStoreRequest;
use App\Http\Requests\Admin\WikipediaItemUpdateRequest;
use App\Http\Resources\Admin\WikipediaItemResource;
use App\Models\WikipediaItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('wikipedia-items')]
class WikipediaItemController extends Controller
{
    #[Get('fetch', name: 'wikipedia-items.fetch')]
    public function fetch(Request $request)
    {
        return WikipediaItemResource::collection(
            WikipediaItem::query()
                ->where('search_query', 'like', "%{$request->input('filter.q')}%")
                ->get()
        );
    }

    #[Get('/', name: 'wikipedia-items')]
    public function index()
    {
        return app(WikipediaItemQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('wikipedia-items/Index', $data))
        ;
    }

    #[Get('create', name: 'wikipedia-items.create')]
    public function create()
    {
        return Inertia::render('wikipedia-items/Create');
    }

    #[Get('{wikipediaItem}', name: 'wikipedia-items.show')]
    public function show(WikipediaItem $wikipediaItem)
    {
        return Inertia::render('wikipedia-items/Edit', [
            'wikipedia-item' => WikipediaItemResource::make($wikipediaItem), // $wikipediaItems->load('relation')
        ]);
    }

    #[Get('{wikipediaItem}/edit', name: 'wikipedia-items.edit')]
    public function edit(WikipediaItem $wikipediaItem)
    {
        return Inertia::render('wikipedia-items/Edit', [
            'wikipedia-item' => WikipediaItemResource::make($wikipediaItem), // $wikipediaItems->load('relation')
        ]);
    }

    #[Post('/', name: 'wikipedia-items.store')]
    public function store(WikipediaItemStoreRequest $request)
    {
        $wikipediaItems = WikipediaItem::create($request->all());

        return redirect()->route('admin.wikipedia-items')->with('flash.success', __('WikipediaItem created.'));
    }

    #[Put('{wikipediaItem}', name: 'wikipedia-items.update')]
    public function update(WikipediaItem $wikipediaItem, WikipediaItemUpdateRequest $request)
    {
        $wikipediaItem->update($request->all());

        return redirect()->route('admin.wikipedia-items')->with('flash.success', __('WikipediaItem updated.'));
    }

    #[Delete('{wikipediaItem}', name: 'wikipedia-items.destroy')]
    public function destroy(WikipediaItem $wikipediaItem)
    {
        $wikipediaItem->delete();

        return redirect()->route('admin.wikipedia-items')->with('flash.success', __('WikipediaItem deleted.'));
    }

    #[Delete('/', name: 'wikipedia-items.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = WikipediaItem::query()->findMany($request->input('ids'))
            ->each(fn (WikipediaItem $wikipediaItem) => $wikipediaItem->delete())
            ->count()
        ;

        return redirect()->route('admin.wikipedia-items')->with('flash.success', __(':count WikipediaItems deleted.', ['count' => $count]));
    }
}
