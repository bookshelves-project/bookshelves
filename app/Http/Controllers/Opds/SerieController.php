<?php

namespace App\Http\Controllers\Opds;

use App\Facades\OpdsSetup;
use App\Http\Controllers\Controller;
use App\Models\Serie;
use Kiwilan\Opds\Entries\OpdsEntryNavigation;
use Kiwilan\Opds\Opds;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('series')]
class SerieController extends Controller
{
    #[Get('/', name: 'opds.series.index')]
    public function index()
    {
        $alphabet = range('A', 'Z');
        $feeds = [];

        foreach ($alphabet as $char) {
            $char_lower = strtolower($char);
            $feeds[] = new OpdsEntryNavigation(
                id: "series.{$char_lower}",
                title: "{$char}",
                route: route('opds.series.character', ['character' => $char_lower]),
                summary: "Series beginning with {$char}",
                media: asset('vendor/images/no-cover.jpg'),
            );
        }

        Opds::make(OpdsSetup::config())
            ->title('Series')
            ->feeds($feeds)
            ->send();
    }

    #[Get('/{character}', name: 'opds.series.character')]
    public function character(string $character)
    {
        $series = Serie::query()
            ->with(['media', 'library', 'language'])
            ->withCount(['books'])
            ->orderBy('title')
            ->whereFirstChar($character)
            ->whereHasBooks()
            ->get();

        $feeds = [];

        foreach ($series as $serie) {
            $description = $serie->description;
            $count = $serie->books_count;

            $feeds[] = new OpdsEntryNavigation(
                id: $serie->slug,
                title: "{$serie->title} ({$serie->language?->name})",
                route: route('opds.series.show', ['character' => $character, 'serie' => $serie->slug]),
                summary: "{$count} books, {$description}",
                media: $serie->cover_social,
                updated: $serie->updated_at,
            );
        }

        OpdsSetup::app()
            ->title("Series with {$character}")
            ->feeds($feeds)
            ->send();
    }

    #[Get('/{character}/{serie}', name: 'opds.series.show')]
    public function show(string $character, string $serie)
    {
        $serie = Serie::query()
            ->where('slug', $serie)
            ->firstOrFail();
        $feeds = [];

        foreach ($serie->books as $book) {
            $feeds[] = OpdsSetup::bookToEntry($book);
        }

        OpdsSetup::app()
            ->title("Serie {$serie->title}")
            ->feeds($feeds)
            ->paginate()
            ->send();
    }
}
