<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\BookQuery;
use App\Http\Requests\Admin\BookStoreRequest;
use App\Http\Requests\Admin\BookUpdateRequest;
use App\Http\Resources\Admin\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/', name: 'books')]
    public function index()
    {
        return app(BookQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('books/Index', $data))
        ;
    }

    #[Get('create', name: 'books.create')]
    public function create()
    {
        return Inertia::render('books/Create');
    }

    #[Get('{book}', name: 'books.show')]
    public function show(Book $book)
    {
        return Inertia::render('books/Edit', [
            'book' => BookResource::make($book->load('serie', 'authors', 'media', 'tags')),
        ]);
    }

    #[Get('{book}/edit', name: 'books.edit')]
    public function edit(Book $book)
    {
        return Inertia::render('books/Edit', [
            'book' => BookResource::make($book->load('serie', 'authors', 'media', 'tags')),
        ]);
    }

    #[Post('/', name: 'books.store')]
    public function store(BookStoreRequest $request)
    {
        $book = Book::create($request->all());

        return redirect()->route('admin.books')->with('flash.success', __('Book created.'));
    }

    #[Put('{book}', name: 'books.update')]
    public function update(Book $book, BookUpdateRequest $request)
    {
        $book->update($request->all());

        return redirect()->route('admin.books')->with('flash.success', __('Book updated.'));
    }

    #[Patch('{book}/toggle', name: 'books.toggle')]
    public function toggle(Book $book, Request $request)
    {
        $request->validate([
            'disabled' => 'sometimes|boolean',
        ]);

        $book->update($request->only('disabled'));

        return redirect()->route('admin.books')->with('flash.success', __('Book updated.'));
    }

    #[Delete('{book}', name: 'books.destroy')]
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books')->with('flash.success', __('Book deleted.'));
    }

    #[Delete('/', name: 'books.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Book::query()->findMany($request->input('ids'))
            ->each(fn (Book $book) => $book->delete())
            ->count()
        ;

        return redirect()->route('admin.books')->with('flash.success', __(':count books deleted.', ['count' => $count]));
    }
}
