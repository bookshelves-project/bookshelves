<?php

namespace App\Http\Controllers\Opds;

use App\Facades\OpdsSetup;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Support\Str;
use Kiwilan\Opds\Entries\OpdsEntryNavigation;
use Kiwilan\Opds\Opds;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'opds.authors.index')]
    public function index()
    {
        $alphabet = range('A', 'Z');
        $feeds = [];

        foreach ($alphabet as $char) {
            $char_lower = strtolower($char);
            $feeds[] = new OpdsEntryNavigation(
                id: "authors.{$char_lower}",
                title: "{$char}",
                route: route('opds.authors.character', ['character' => $char_lower]),
                summary: "Authors beginning with {$char}",
            );
        }

        OpdsSetup::app()
            ->title('Authors')
            ->feeds($feeds)
            ->send();
    }

    #[Get('/{character}', name: 'opds.authors.character')]
    public function character(string $character)
    {
        $authors = Author::query()
            ->with(['media'])
            ->withCount(['books', 'booksOnlyBook'])
            ->orderBy('lastname')
            ->whereFirstChar($character)
            ->whereHasBooks()
            ->get();

        $feeds = [];

        /** @var Author $author */
        foreach ($authors as $author) {
            $feeds[] = new OpdsEntryNavigation(
                id: Str::slug("{$author->lastname} {$author->firstname}"),
                title: "{$author->lastname}, {$author->firstname}",
                route: route('opds.authors.show', ['character' => $character, 'author' => $author->slug]),
                summary: "{$author->books_only_book_count} books",
                updated: $author->updated_at,
            );
        }

        OpdsSetup::app()
            ->title("Authors with {$character}")
            ->feeds($feeds)
            ->send();
    }

    #[Get('/{character}/{author}', name: 'opds.authors.show')]
    public function show(string $character, string $author)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $feeds = [];

        foreach ($author->booksOnlyBook as $book) {
            $feeds[] = OpdsSetup::bookToEntry($book);
        }

        Opds::make(OpdsSetup::config())
            ->title("Author {$author->lastname} {$author->firstname}")
            ->feeds($feeds)
            ->paginate()
            ->send();
    }
}
