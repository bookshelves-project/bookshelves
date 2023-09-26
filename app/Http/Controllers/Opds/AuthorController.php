<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsApp;
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
        $feeds = OpdsApp::cache('opds.authors.index', function () {
            $alphabet = range('A', 'Z');
            $feeds = [];

            foreach ($alphabet as $char) {
                $id = strtolower($char);
                $count = Author::query()
                    ->orderBy('lastname')
                    ->whereFirstCharacterIs($char)
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

        Opds::make(OpdsApp::config())
            ->title('Authors')
            ->feeds($feeds)
            ->send();
    }

    #[Get('/{character}', name: 'opds.authors.character')]
    public function character(string $character)
    {
        $lower = strtolower($character);
        $feeds = OpdsApp::cache("opds.authors.character.{$lower}", function () use ($character) {
            $authors = Author::query()
                ->orderBy('lastname')
                ->whereFirstCharacterIs($character)
                ->get();

            $feeds = [];

            foreach ($authors as $author) {
                $description = $author->description;
                $count = $author->books_count;

                $feeds[] = new OpdsEntryNavigation(
                    id: $author->slug,
                    title: "{$author->lastname} {$author->firstname}",
                    route: route('opds.authors.show', ['character' => $character, 'author' => $author->slug]),
                    summary: "{$count} books, {$description}",
                    media: $author->cover_og,
                    updated: $author->updated_at,
                );
            }

            return $feeds;
        });

        Opds::make(OpdsApp::config())
            ->title("Authors with {$character}")
            ->feeds($feeds)
            ->send();
    }

    #[Get('/{character}/{author}', name: 'opds.authors.show')]
    public function show(string $character, string $author_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $feeds = [];

        foreach ($author->books as $book) {
            $feeds[] = OpdsApp::bookToEntry($book);
        }

        Opds::make(OpdsApp::config()->usePagination())
            ->title("Author {$author->lastname} {$author->firstname}")
            ->feeds($feeds)
            ->send();
    }
}
