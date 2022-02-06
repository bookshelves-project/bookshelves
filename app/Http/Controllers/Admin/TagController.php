<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\TagQuery;
use App\Http\Resources\Admin\TagResource;
use App\Models\TagExtend;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('tags')]
class TagController extends Controller
{
    #[Get('/', name: 'tags')]
    public function index()
    {
        return app(TagQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('tags/Index', $data))
        ;
    }

    #[Get('create', name: 'tags.create')]
    public function create()
    {
        return Inertia::render('tags/Create');
    }

    #[Get('{tag}/edit', name: 'tags.edit')]
    public function edit(TagExtend $tag)
    {
        return Inertia::render('stubs/Edit', [
            'tag' => TagResource::make($tag), // $stubPascal->load('relation')
        ]);
    }

    #[Delete('{tag}', name: 'tags.destroy')]
    public function destroy(TagExtend $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags')->with('flash.success', __('Tag deleted.'));
    }

    #[Delete('/', name: 'tags.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = TagExtend::query()->findMany($request->input('ids'))
            ->each(fn (TagExtend $tag) => $tag->delete())
            ->count()
        ;

        return redirect()->route('admin.tags')->with('flash.success', __(':count tags deleted.', ['count' => $count]));
    }

    #[Get('fetch', name: 'tags.fetch')]
    public function fetch(Request $request)
    {
        return TagResource::collection(
            TagExtend::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->ordered()->get()
        );
    }
}
