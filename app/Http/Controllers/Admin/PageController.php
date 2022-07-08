<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\PageQuery;
use App\Http\Requests\Admin\PageStoreRequest;
use App\Http\Requests\Admin\PageUpdateRequest;
use App\Http\Resources\Admin\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('pages')]
class PageController extends Controller
{
    #[Get('fetch', name: 'pages.fetch')]
    public function fetch(Request $request)
    {
        return PageResource::collection(
            Page::query()
                ->where('title', 'like', "%{$request->input('filter.q')}%")
                ->get()
        );
    }

    #[Get('/', name: 'pages')]
    public function index()
    {
        return app(PageQuery::class)->make(null)
            ->paginateOrExport(fn ($data) => Inertia::render('pages/Index', $data));
    }

    #[Get('create', name: 'pages.create')]
    public function create()
    {
        return Inertia::render('pages/Create');
    }

    #[Get('{page}', name: 'pages.show')]
    public function show(Page $page)
    {
        return Inertia::render('pages/Edit', [
            'page' => PageResource::make($page), // $pages->load('relation')
        ]);
    }

    #[Get('{page}/edit', name: 'pages.edit')]
    public function edit(Page $page)
    {
        return Inertia::render('pages/Edit', [
            'page' => PageResource::make($page), // $pages->load('relation')
        ]);
    }

    #[Post('/', name: 'pages.store')]
    public function store(PageStoreRequest $request)
    {
        $pages = Page::create($request->all());

        return redirect()->route('admin.pages')->with('flash.success', __('Page created.'));
    }

    #[Post('{page}', name: 'pages.update')]
    public function update(Page $page, PageUpdateRequest $request)
    {
        $page->update($request->all());

        if ($request->featured_image_file) {
            $page->addMediaFromRequest('featured_image_file')
                ->toMediaCollection('featured-image');
        }

        return redirect()->route('admin.pages')->with('flash.success', __('Page updated.'));
    }

    #[Delete('{page}', name: 'pages.destroy')]
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages')->with('flash.success', __('Page deleted.'));
    }

    #[Delete('/', name: 'pages.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Page::query()->findMany($request->input('ids'))
            ->each(fn (Page $page) => $page->delete())
            ->count();

        return redirect()->route('admin.pages')->with('flash.success', __(':count Pages deleted.', ['count' => $count]));
    }
}
