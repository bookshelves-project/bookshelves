<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\AuthorQuery;
use App\Http\Requests\Admin\PostStoreRequest;
use App\Http\Requests\Admin\PostUpdateRequest;
use App\Http\Resources\Admin\AuthorResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index()
    {
        return app(AuthorQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('authors/Index', $data))
        ;
    }

    public function create()
    {
        return Inertia::render('authors/Create');
    }

    public function edit(Author $author)
    {
        return Inertia::render('authors/Edit', [
            'author' => AuthorResource::make($author->load('books', 'media')),
        ]);
    }

    public function store(PostStoreRequest $request)
    {
        $author = Author::create($request->all());

        // if ($request->featured_image_file) {
        //     $book->addMediaFromRequest('featured_image_file')
        //         ->toMediaCollection('featured-image')
        //     ;
        // }

        return redirect()->route('admin.authors')->with('flash.success', __('Author created.'));
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
