<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\SerieQuery;
use App\Http\Requests\Admin\PostStoreRequest;
use App\Http\Requests\Admin\PostUpdateRequest;
use App\Http\Resources\Admin\SerieResource;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SerieController extends Controller
{
    public function index()
    {
        return app(SerieQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('series/Index', $data))
        ;
    }

    public function create()
    {
        return Inertia::render('series/Create');
    }

    public function edit(Serie $serie)
    {
        return Inertia::render('series/Edit', [
            'serie' => SerieResource::make($serie->load('media', 'books', 'tags', 'authors')),
        ]);
    }

    public function store(PostStoreRequest $request)
    {
        $serie = Serie::create($request->all());

        $serie->syncTags($request->tags);

        // if ($request->featured_image_file) {
        //     $serie->addMediaFromRequest('featured_image_file')
        //         ->toMediaCollection('featured-image')
        //     ;
        // }

        return redirect()->route('admin.series')->with('flash.success', __('Serie created.'));
    }

    public function update(Book $book, PostUpdateRequest $request)
    {
        $book->update($request->all());

        $book->syncTags($request->tags);

        if ($request->featured_image_delete) {
            $book->clearMediaCollection('featured-image');
        }

        if ($request->featured_image_file) {
            $book->addMediaFromRequest('featured_image_file')
                ->toMediaCollection('featured-image')
            ;
        }

        return redirect()->route('admin.books')->with('flash.success', __('Book updated.'));
    }

    public function toggle(Book $book, Request $request)
    {
        $request->validate([
            'pin' => 'sometimes|boolean',
            'promote' => 'sometimes|boolean',
        ]);

        $book->update($request->only('pin', 'promote'));

        return redirect()->route('admin.books')->with('flash.success', __('Book updated.'));
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books')->with('flash.success', __('Book deleted.'));
    }

    public function bulkDestroy(Request $request)
    {
        $count = Book::query()->findMany($request->input('ids'))
            ->each(fn (Book $book) => $book->delete())
            ->count()
        ;

        return redirect()->route('admin.books')->with('flash.success', __(':count books deleted.', ['count' => $count]));
    }
}
