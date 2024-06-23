<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Library;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

// #[Prefix('libraries')]
class BookController extends Controller
{
    // Moved to `routes/web.php` for priority
    // #[Get('/{library:slug}/{book:slug}', name: 'books.show')]
    public function show(Library $library, Book $book)
    {
        $book->load([
            'authors',
            'serie',
            'serie.books',
            'serie.books.serie',
            'serie.books.media',
            'serie.books.language',
            'serie.books.library',
            'serie.books.authors',
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
            'square' => $book->library?->type->isAudiobook(),
        ]);
    }
}
