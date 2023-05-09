<?php

namespace App\Http\Controllers\Opds;

use App\Engines\MyOpds;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Kiwilan\Opds\Entries\OpdsEntry;
use Kiwilan\Opds\Opds;
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
        $entries = MyOpds::cache('opds.authors.index', function () {
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

        return Opds::response(
            config: MyOpds::config(),
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
            $entries[] = MyOpds::bookToEntry($book);
        }

        return Opds::response(
            config: MyOpds::config(),
            entries: $entries,
            title: "Author {$author->lastname} {$author->firstname}",
        );
    }
}
