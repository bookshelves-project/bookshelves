<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\GoogleBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Queries\GoogleBookQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Prefix;
use App\Http\Resources\Admin\GoogleBookResource;
use App\Http\Requests\Admin\GoogleBookStoreRequest;
use App\Http\Requests\Admin\GoogleBookUpdateRequest;

#[Prefix('google-books')]
class GoogleBookController extends Controller
{
    #[Get('fetch', name: 'google-books.fetch')]
    public function fetch(Request $request)
    {
        return GoogleBookResource::collection(
            GoogleBook::query()
                ->where('original_isbn', 'like', "%{$request->input('filter.q')}%")
                ->get()
        );
    }

    #[Get('/', name: 'google-books')]
    public function index()
    {
        return app(GoogleBookQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('google-books/Index', $data))
        ;
    }

    #[Get('create', name: 'google-books.create')]
    public function create()
    {
        return Inertia::render('google-books/Create');
    }

    #[Get('{googleBook}', name: 'google-books.show')]
    public function show(GoogleBook $googleBook)
    {
        return Inertia::render('google-books/Edit', [
            'google-book' => GoogleBookResource::make($googleBook), // $googleBooks->load('relation')
        ]);
    }

    #[Get('{googleBook}/edit', name: 'google-books.edit')]
    public function edit(GoogleBook $googleBook)
    {
        return Inertia::render('google-books/Edit', [
            'google-book' => GoogleBookResource::make($googleBook), // $googleBooks->load('relation')
        ]);
    }

    #[Post('/', name: 'google-books.store')]
    public function store(GoogleBookStoreRequest $request)
    {
        $googleBooks = GoogleBook::create($request->all());

        return redirect()->route('admin.google-books')->with('flash.success', __('GoogleBook created.'));
    }

    #[Put('{googleBook}', name: 'google-books.update')]
    public function update(GoogleBook $googleBook, GoogleBookUpdateRequest $request)
    {
        $googleBook->update($request->all());

        return redirect()->route('admin.google-books')->with('flash.success', __('GoogleBook updated.'));
    }

    #[Delete('{googleBook}', name: 'google-books.destroy')]
    public function destroy(GoogleBook $googleBook)
    {
        $googleBook->delete();

        return redirect()->route('admin.google-books')->with('flash.success', __('GoogleBook deleted.'));
    }

    #[Delete('/', name: 'google-books.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = GoogleBook::query()->findMany($request->input('ids'))
            ->each(fn (GoogleBook $googleBook) => $googleBook->delete())
            ->count()
        ;

        return redirect()->route('admin.google-books')->with('flash.success', __(':count GoogleBooks deleted.', ['count' => $count]));
    }
}
