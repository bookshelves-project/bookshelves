<?php

namespace App\Http\Controllers\Opds;

use App\Facades\OpdsBase;
use App\Http\Controllers\Controller;
use App\Models\Author;
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
        $feeds = OpdsBase::cache('opds.authors.index', function () {
            $alphabet = range('A', 'Z');
            $feeds = [];

            foreach ($alphabet as $char) {
                $id = strtolower($char);
                $count = Author::query()
                    ->orderBy('name')
                    ->whereFirstChar($char)
                    ->whereHasBooks()
                    ->count();

                $feeds[] = new OpdsEntryNavigation(
                    id: $id,
                    title: "{$char} ({$count} entries)",
                    route: route('opds.authors.character', ['character' => $id]),
                    summary: "Authors beginning with {$char}",
                    media: asset('vendor/images/no-author.jpg'),
                );
            }

            return $feeds;
        });

        OpdsBase::app()
            ->title('Authors')
            ->feeds($feeds)
            ->send(true);
    }

    #[Get('/{character}', name: 'opds.authors.character')]
    public function character(string $character)
    {
        $lower = strtolower($character);
        $feeds = OpdsBase::cache("opds.authors.character.{$lower}", function () use ($character) {
            $authors = Author::query()
                ->with(['media'])
                ->withCount('books')
                ->orderBy('name')
                ->whereFirstChar($character)
                ->whereHasBooks()
                ->get();

            $feeds = [];

            foreach ($authors as $author) {
                $description = $author->description;
                $count = $author->books_count;

                $feeds[] = new OpdsEntryNavigation(
                    id: $author->slug,
                    title: "{$author->firstname} {$author->lastname}",
                    route: route('opds.authors.show', ['character' => $character, 'author' => $author->slug]),
                    summary: "{$count} books, {$description}",
                    media: $author->cover_social,
                    updated: $author->updated_at,
                );
            }

            return $feeds;
        });

        OpdsBase::app()
            ->title("Authors with {$character}")
            ->feeds($feeds)
            ->send(true);
    }

    #[Get('/{character}/{author}', name: 'opds.authors.show')]
    public function show(string $character, string $author)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $feeds = [];

        foreach ($author->books as $book) {
            $feeds[] = OpdsBase::bookToEntry($book);
        }

        Opds::make(OpdsBase::config())
            ->title("Author {$author->lastname} {$author->firstname}")
            ->feeds($feeds)
            ->paginate()
            ->send(true);
    }
}
