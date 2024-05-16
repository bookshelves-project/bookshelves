<?php

namespace App\Http\Controllers\App;

use App\Enums\LibraryTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('books')]
class BookController extends Controller
{
    #[Get('/{book:slug}', name: 'books.show')]
    public function show(Book $book)
    {
        $book->load([
            'authors',
            'serie',
            'serie.books',
            'serie.books.serie',
            'serie.books.media',
            'tags',
            'media',
            'publisher',
            'language',
            'library',
        ]);

        $title = $book->title;
        if ($book->serie) {
            $title = "{$book->serie->title} {$book->volume_pad} - {$title} by {$book->authors->implode('name', ', ')}";
        } else {
            $title = "{$title} by {$book->authors->implode('name', ', ')}";
        }

        return inertia('Books/Show', [
            'book' => $book,
            'square' => $book->library?->type === LibraryTypeEnum::audiobook,
        ]);
    }
}
