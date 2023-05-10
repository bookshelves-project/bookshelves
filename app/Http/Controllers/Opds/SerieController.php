<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsApp;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Serie;
use Kiwilan\Opds\Entries\OpdsEntry;
use Kiwilan\Opds\Opds;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/', name: 'series.index')]
    public function index()
    {
        $entries = OpdsApp::cache('opds.series.index', function () {
            $items = Serie::with('books', 'media', 'authorMain')
                ->orderBy('slug_sort')
                ->get()
            ;

            $entries = [];

            foreach ($items as $item) {
                /** @var Serie $item */
                $entries[] = new OpdsEntry(
                    id: $item->slug,
                    title: $item->title,
                    route: route('opds.series.show', ['author' => $item->authorMain?->slug, 'serie' => $item->slug]),
                    summary: $item->description,
                    media: $item->cover_og,
                    updated: $item->updated_at,
                );
            }

            return $entries;
        });

        return Opds::response(
            config: OpdsApp::config(),
            entries: (array) $entries,
            title: 'Series',
        );
    }

    #[Get('/{author}/{serie}', name: 'series.show')]
    public function show(string $author_slug, string $serie_slug)
    {
        $author = Author::whereSlug($author_slug)->firstOrFail();
        $serie = Serie::whereAuthorMainId($author->id)
            ->whereSlug($serie_slug)
            ->firstOrFail()
        ;

        $entries = [];

        foreach ($serie->books as $book) {
            $entries[] = OpdsApp::bookToEntry($book);
        }

        return Opds::response(
            config: OpdsApp::config(),
            entries: (array) $entries,
            title: "Serie {$serie->title}",
        );
    }
}
