<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\TagQuery;
use App\Http\Requests\Admin\TagStoreRequest;
use App\Http\Requests\Admin\TagUpdateRequest;
use App\Http\Resources\Admin\TagResource;
use App\Models\TagExtend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\Tags\Tag;

#[Prefix('tags')]
class TagController extends Controller
{
    #[Get('fetch', name: 'tags.fetch')]
    public function fetch(Request $request)
    {
        $query = $request->input('filter.q');

        $tags = Tag::where(DB::raw(
            "lower(json_unquote(json_extract(name, '$.en')))"
        ), 'LIKE', '%'.strtolower($query).'%');

        return TagResource::collection(
            $tags->ordered()
                ->get()
        );
    }

    #[Get('/', name: 'tags')]
    public function index()
    {
        return app(TagQuery::class)->make(null)
            ->paginateOrExport(fn ($data) => Inertia::render('tags/Index', $data))
        ;
    }

    #[Get('create', name: 'tags.create')]
    public function create()
    {
        return Inertia::render('tags/Create');
    }

    #[Get('{tag}', name: 'tags.show')]
    public function show(TagExtend $tag)
    {
        return Inertia::render('tags/Edit', [
            'tag' => TagResource::make($tag),
        ]);
    }

    #[Post('/', name: 'tags.store')]
    public function store(TagStoreRequest $request)
    {
        $tag = TagExtend::create($request->all());

        return redirect()->route('admin.tags')->with('flash.success', __('Tag created.'));
    }

    #[Get('{tag}/edit', name: 'tags.edit')]
    public function edit(TagExtend $tag)
    {
        return Inertia::render('tags/Edit', [
            'tag' => TagResource::make($tag), // $stubConcat->load('relation')
        ]);
    }

    #[Put('{tag}', name: 'tags.update')]
    public function update(TagExtend $tag, TagUpdateRequest $request)
    {
        $tag->update($request->all());

        return redirect()->route('admin.tags')->with('flash.success', __('Tag updated.'));
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
}
