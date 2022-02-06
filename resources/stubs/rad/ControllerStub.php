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
use Spatie\RouteAttributes\Attributes\Post as HttpPost;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('stubs')]
class StubController extends Controller
{
    #[Get('/', name: 'stubs')]
    public function index()
    {
        return app(StubQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('stubs/Index', $data))
        ;
    }

    #[Get('create', name: 'stubs.create')]
    public function create()
    {
        return Inertia::render('stubs/Create');
    }

    #[Get('{stub}/edit', name: 'stubs.edit')]
    public function edit(Stub $stubVar)
    {
        return Inertia::render('stubs/Edit', [
            'stub' => StubResource::make($stubVar->load('')),
        ]);
    }

    #[HttpPost('/', name: 'stubs.store')]
    public function store(StubStoreRequest $request)
    {
        $stubVar = Stub::create($request->all());

        return redirect()->route('admin.stubs')->with('flash.success', __('Stub created.'));
    }

    #[Put('{stub}', name: 'stubs.update')]
    public function update(Stub $stubVar, StubUpdateRequest $request)
    {
        $stubVar->update($request->all());

        return redirect()->route('admin.stubs')->with('flash.success', __('Stub updated.'));
    }

    #[Delete('{stub}', name: 'stubs.destroy')]
    public function destroy(Stub $stubVar)
    {
        $stubVar->delete();

        return redirect()->route('admin.stubs')->with('flash.success', __('Stub deleted.'));
    }

    #[Delete('/', name: 'stubs.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Stub::query()->findMany($request->input('ids'))
            ->each(fn (Stub $stubVar) => $stubVar->delete())
            ->count()
        ;

        return redirect()->route('admin.stubs')->with('flash.success', __(':count stubs deleted.', ['count' => $count]));
    }
}
