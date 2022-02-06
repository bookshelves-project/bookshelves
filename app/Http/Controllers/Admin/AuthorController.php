<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\AuthorQuery;
use App\Http\Resources\Admin\AuthorResource;
use App\Models\Author;
use Inertia\Inertia;
use Request;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'authors')]
    public function index()
    {
        return app(AuthorQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('authors/Index', $data))
        ;
    }

    #[Get('create', name: 'authors.create')]
    public function create()
    {
        return Inertia::render('authors/Create');
    }

    #[Get('{author}', name: 'authors.show')]
    public function show(Author $author)
    {
        return Inertia::render('authors/Edit', [
            'author' => AuthorResource::make($author->load('books', 'series')),
        ]);
    }

    #[Get('{author}/edit', name: 'authors.edit')]
    public function edit(Author $author)
    {
        return Inertia::render('authors/Edit', [
            'author' => AuthorResource::make($author->load('books', 'series')),
        ]);
    }

    #[Post('/', name: 'authors.store')]
    public function store(Request $request)
    {
        $author = Author::create($request->all());

        return redirect()->route('admin.authors')->with('flash.success', __('Author created.'));
    }

    #[Put('{author}', name: 'authors.update')]
    public function update(Author $author, Request $request)
    {
        $author->update($request->all());

        return redirect()->route('admin.authors')->with('flash.success', __('Author updated.'));
    }

    #[Delete('{author}', name: 'authors.destroy')]
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('admin.authors')->with('flash.success', __('Author deleted.'));
    }

    #[Delete('/', name: 'authors.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Author::query()->findMany($request->input('ids'))
            ->each(fn (Author $author) => $author->delete())
            ->count()
        ;

        return redirect()->route('admin.authors')->with('flash.success', __(':count authors deleted.', ['count' => $count]));
    }
}
