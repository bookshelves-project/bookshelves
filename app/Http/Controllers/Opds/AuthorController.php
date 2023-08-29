<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsApp;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Kiwilan\Opds\Entries\OpdsEntry;
use Kiwilan\Opds\Opds;
use Kiwilan\Opds\OpdsConfig;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'authors.index')]
    public function index()
    {
        $feeds = OpdsApp::cache('opds.authors.index', function () {
            $alphabet = range('A', 'Z');
            //     $items = Author::with('media')
            //         ->orderBy('lastname')
            //         ->get()
            //     ;

            $feeds = [];

            foreach ($alphabet as $char) {
                $id = strtolower($char);
                $feeds[] = new OpdsEntry(
                    id: $id,
                    title: $char,
                    route: route('opds.authors.character', ['character' => $id]),
                    // id: $item->slug,
                    // title: "{$item->lastname} {$item->firstname}",
                    // route: route('opds.authors.show', ['author' => $item->slug]),
                    // summary: "{$count} books, {$description}",
                    // media: $item->cover_og,
                    // updated: $item->updated_at,
                );
            }

            return $feeds;
        });

        return Opds::make(
            config: OpdsApp::config(),
            feeds: (array) $feeds,
            title: 'Authors',
        )->response();
    }

    #[Get('/{character}', name: 'authors.character')]
    public function character(string $character)
    {
        $lower = strtolower($character);
        $feeds = OpdsApp::cache("opds.authors.character.{$lower}", function () use ($character) {
            $authors = Author::query()
                ->orderBy('lastname')
                ->whereFirstCharacterIs($character)
                ->get()
            ;

            $feeds = [];

            foreach ($authors as $author) {
                $description = $author->description;
                $count = $author->books_count;

                $feeds[] = new OpdsEntry(
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

        return Opds::make(
            config: OpdsApp::config(new OpdsConfig(
                usePagination: false
            )),
            feeds: $feeds,
            title: "Authors with {$character}",
        )->response();
    }

    #[Get('/{character}/{author}', name: 'authors.show')]
    public function show(string $character, string $author_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $feeds = [];

        foreach ($author->books as $book) {
            $feeds[] = OpdsApp::bookToEntry($book);
        }

        return Opds::make(
            config: OpdsApp::config(),
            feeds: $feeds,
            title: "Author {$author->lastname} {$author->firstname}",
        )->response();
    }
}
