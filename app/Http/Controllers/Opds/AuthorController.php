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

        // $authorsCount = Author::query()
        //     ->orderBy('lastname')
        //     ->whereHasBooks()
        //     ->get(['lastname', 'firstname']);
        // dd($authorsCount);

        foreach ($alphabet as $char) {
            $id = strtolower($char);
            // $count = OpdsSetup::cache("opds.authors.index.{$char}", function () use ($char) {
            //     return Author::query()
            //         ->orderBy('lastname')
            //         ->whereFirstChar($char)
            //         ->whereHasBooks()
            //         ->count();
            // });

            // $count = Author::query()
            //     ->orderBy('lastname')
            //     ->whereFirstChar($char)
            //     ->whereHasBooks()
            //     ->count();

            $feeds[] = new OpdsEntryNavigation(
                id: $id,
                // title: "{$char} ({$count} entries)",
                title: "{$char}",
                route: route('opds.authors.character', ['character' => $id]),
                summary: "Authors beginning with {$char}",
                media: asset('vendor/images/no-author.jpg'),
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
        $lower = strtolower($character);
        $authors = OpdsSetup::cache("opds.authors.character.{$lower}", function () use ($character) {
            return Author::query()
                ->with(['media'])
                ->withCount('books')
                ->orderBy('lastname')
                ->whereFirstChar($character)
                ->whereHasBooks()
                ->get();
        });

        $feeds = [];

        foreach ($authors as $author) {
            $feeds[] = new OpdsEntryNavigation(
                id: Str::slug("{$author->lastname} {$author->firstname}"),
                title: "{$author->lastname}, {$author->firstname}",
                route: route('opds.authors.show', ['character' => $character, 'author' => $author->slug]),
                summary: "{$author->books_count} books",
                media: $author->cover_social,
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
