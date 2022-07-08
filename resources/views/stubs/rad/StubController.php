<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\StubQuery;
use App\Http\Requests\Admin\StubStoreRequest;
use App\Http\Requests\Admin\StubUpdateRequest;
use App\Http\Resources\Admin\StubResource;
use App\Models\Stub;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('stubsKebab')]
class StubController extends Controller
{
    #[Get('fetch', name: 'stubsKebab.fetch')]
    public function fetch(Request $request)
    {
        return StubResource::collection(
            Stub::query()
                ->where('stubAttr', 'like', "%{$request->input('filter.q')}%")
                ->get()
        );
    }

    #[Get('/', name: 'stubsKebab')]
    public function index()
    {
        return app(StubQuery::class)->make(null)
            ->paginateOrExport(fn ($data) => Inertia::render('stubsKebab/Index', $data));
    }

    #[Get('create', name: 'stubsKebab.create')]
    public function create()
    {
        return Inertia::render('stubsKebab/Create');
    }

    #[Get('{stubPascal}', name: 'stubsKebab.show')]
    public function show(Stub $stubPascal)
    {
        return Inertia::render('stubsKebab/Edit', [
            'stubKebab' => StubResource::make($stubPascal), // $stubsPascal->load('relation')
        ]);
    }

    #[Get('{stubPascal}/edit', name: 'stubsKebab.edit')]
    public function edit(Stub $stubPascal)
    {
        return Inertia::render('stubsKebab/Edit', [
            'stubKebab' => StubResource::make($stubPascal), // $stubsPascal->load('relation')
        ]);
    }

    #[Post('/', name: 'stubsKebab.store')]
    public function store(StubStoreRequest $request)
    {
        $stubsPascal = Stub::create($request->all());

        return redirect()->route('admin.stubsKebab')->with('flash.success', __('Stub created.'));
    }

    #[Put('{stubPascal}', name: 'stubsKebab.update')]
    public function update(Stub $stubPascal, StubUpdateRequest $request)
    {
        $stubPascal->update($request->all());

        return redirect()->route('admin.stubsKebab')->with('flash.success', __('Stub updated.'));
    }

    #[Delete('{stubPascal}', name: 'stubsKebab.destroy')]
    public function destroy(Stub $stubPascal)
    {
        $stubPascal->delete();

        return redirect()->route('admin.stubsKebab')->with('flash.success', __('Stub deleted.'));
    }

    #[Delete('/', name: 'stubsKebab.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Stub::query()->findMany($request->input('ids'))
            ->each(fn (Stub $stubPascal) => $stubPascal->delete())
            ->count();

        return redirect()->route('admin.stubsKebab')->with('flash.success', __(':count Stubs deleted.', ['count' => $count]));
    }
}
