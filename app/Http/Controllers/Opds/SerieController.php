<?php

namespace App\Http\Controllers\Opds;

use App\Engines\Opds\Config\OpdsEntry;
use App\Engines\OpdsConfig;
use App\Engines\OpdsEngine;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Serie;
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
        $entries = OpdsConfig::cache('opds.series.index', function () {
            $items = Serie::with('books', 'media')
                ->orderBy('slug_sort')
                ->get()
            ;

            $entries = [];

            foreach ($items as $item) {
                /** @var Serie $item */
                $entries[] = new OpdsEntry(
                    id: $item->slug,
                    title: $item->title,
                    route: route('opds.series.show', ['author' => $item->meta_author, 'serie' => $item->slug]),
                    summary: $item->description,
                    media: $item->cover_og,
                    updated: $item->updated_at,
                );
            }

            return $entries;
        });

        return OpdsEngine::response(
            app: OpdsConfig::app(),
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
            $entries[] = OpdsConfig::bookToEntry($book);
        }

        return OpdsEngine::response(
            app: OpdsConfig::app(),
            entries: (array) $entries,
            title: "Serie {$serie->title}",
        );
    }
}
