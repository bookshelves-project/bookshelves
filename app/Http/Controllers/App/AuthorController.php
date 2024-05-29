<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Library;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'authors.index')]
    public function index(Request $request)
    {
        $query = HttpQuery::for(Author::class, $request)
            ->with(['media'])
            ->withCount(['books', 'series'])
            ->defaultSort('slug')
            ->inertia();

        return inertia('Authors/Index', [
            'title' => 'Authors',
            'query' => $query,
            'breadcrumbs' => [
                ['label' => 'Authors', 'route' => ['name' => 'authors.index']],
            ],
        ]);
    }

    #[Get('/{author:slug}', name: 'authors.show')]
    public function show(Author $author)
    {
        $author->load([
            'books',
            'series',
            'media',
            'books.media',
            'books.language',
            'books.serie',
            'books.library',
            'series.media',
            'series.language',
            'series.library',
        ])->withCount(['books', 'series']);

        $libraries = collect();
        foreach (Library::with(['books', 'books.serie'])->get() as $library) {
            $libraries->put($library->slug, [
                'name' => $library->name,
                'books' => [],
            ]);
        }

        // $books = collect();
        // $libraries->each(function ($library) use ($author, $books) {
        // });

        // foreach ($author->books as $book) {
        //     // $books[$book->library->slug]['books'][] = $book->title;
        //     $books->push($book->library->slug, [
        //         'name' => $book->library->name,
        //         // 'books' => $books->get($book->library->slug)['books'] + [$book->title],
        //     ]);
        //     // $books->put($book->library->slug, [
        //     //     'name' => $book->library->name,
        //     //     'books' => $books->get($book->library->slug)['books'] + [$book->title],
        //     // ]);
        // }

        $libraries = collect();
        foreach (Library::all() as $library) {
            $books = $author->books->filter(fn ($book) => $book->library->slug === $library->slug);
            $series = $author->series->filter(fn ($serie) => $serie->library->slug === $library->slug);
            $libraries->push([
                'name' => $library->name,
                'books' => $books->values(),
                'series' => $series->values(),
            ]);
        }

        $libraries = $libraries->filter(fn ($library) => $library['books']->isNotEmpty());
        $libraries = $libraries->values()->toArray();
        ray($libraries);

        // $libraries = $libraries->map(function ($library) use ($author) {
        //     foreach ($library['books'] as &$book) {
        //         foreach ($author->books as $book) {
        //             $book['title'] = 'test';
        //         }
        //     }

        //     return $library;
        // });

        // ray($author->books->map(fn ($book) => $book->title));
        // foreach ($author->books as $book) {
        //     $libraries->push($book->library->slug, [
        //         'name' => $book->library->name,
        //         'books' => $libraries->get($book->library->slug)['books'] + [$book->title],
        //     ]);
        // }
        // ray($libraries->get('ebooks-french'));
        // ray($books);

        return inertia('Authors/Show', [
            'author' => $author,
            'libs' => $libraries,
            'breadcrumbs' => [
                ['label' => 'Authors', 'route' => ['name' => 'authors.index']],
                ['label' => $author->name, 'route' => ['name' => 'authors.show', 'author' => $author->slug]],
            ],
        ]);
    }
}
