<?php

namespace App\Http\Controllers\Opds;

use App\Engines\Opds\Models\OpdsEntry;
use App\Engines\OpdsConfig;
use App\Engines\OpdsEngine;
use App\Http\Controllers\Controller;
use App\Models\Author;
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
        $entries = OpdsConfig::cache('opds.authors.index', function () {
            $items = Author::with('books', 'media')
                ->orderBy('lastname')
                ->get()
            ;

            $entries = [];

            foreach ($items as $item) {
                /** @var Author $item */
                $description = $item->description;
                $count = $item->books_count;

                $entries[] = new OpdsEntry(
                    id: $item->slug,
                    title: "{$item->lastname} {$item->firstname}",
                    route: route('opds.authors.show', ['author' => $item->slug]),
                    summary: "{$count} books, {$description}",
                    media: $item->cover_og,
                    updated: $item->updated_at,
                );
            }

            return $entries;
        });

        return OpdsEngine::response(
            app: OpdsConfig::app(),
            entries: (array) $entries,
            title: 'Authors',
        );
    }

    #[Get('/{author}', name: 'authors.show')]
    public function show(string $author_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();

        $entries = [];

        foreach ($author->books as $book) {
            $entries[] = OpdsConfig::bookToEntry($book);
        }

        return OpdsEngine::response(
            app: OpdsConfig::app(),
            entries: $entries,
            title: "Author {$author->lastname} {$author->firstname}",
        );
    }
}
