<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Services\CommonMarkService;
use Spatie\Tags\Tag;

/**
 * @hideFromAPIDocumentation
 */
class NavigationController extends Controller
{
    public function welcome()
    {
        $markdown = CommonMarkService::generate('welcome/content/index.md');
        $content = $markdown->content;
        $date = $markdown->date;

        $table = [
            [
                'entity' => 'Books',
                'count' => Book::count(),
            ],
            [
                'entity' => 'Series',
                'count' => Serie::count(),
            ],
            [
                'entity' => 'Authors',
                'count' => Author::count(),
            ],
            [
                'entity' => 'Languages',
                'count' => Language::count(),
            ],
            [
                'entity' => 'Publishers',
                'count' => Publisher::count(),
            ],
            [
                'entity' => 'Tags',
                'count' => Tag::count(),
            ],
        ];
        $table = json_decode(json_encode($table));

        $table = [
            [
                'entity' => 'Books',
                'count' => Book::count(),
            ],
            [
                'entity' => 'Series',
                'count' => Serie::count(),
            ],
            [
                'entity' => 'Authors',
                'count' => Author::count(),
            ],
            [
                'entity' => 'Languages',
                'count' => Language::count(),
            ],
            [
                'entity' => 'Publishers',
                'count' => Publisher::count(),
            ],
            [
                'entity' => 'Tags',
                'count' => Tag::count(),
            ],
        ];
        $table = json_decode(json_encode($table));

        $tableConfig = [
            'bookshelves.cover_extension',
            'bookshelves.authors.order_natural',
            'bookshelves.authors.detect_homonyms',
            'bookshelves.langs',
            'bookshelves.tags.genres_list',
            'bookshelves.tags.forbidden',
            'scout.driver',
            'scout.queue',
            'scout.meilisearch',
            'telescope.enabled',
            'clockwork.enable',
            'session.domain',
            'sanctum.stateful',
        ];
        $tableConfig = json_decode(json_encode($tableConfig));

        return view('pages.features.welcome.index', compact('table', 'tableConfig', 'content'));
    }

    public function fallback()
    {
        return response()->json([
            'failed' => 'Route not found',
        ], 404);
    }
}
