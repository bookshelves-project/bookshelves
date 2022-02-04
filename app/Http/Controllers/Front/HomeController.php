<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use App\Services\MarkdownService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use SEOMeta;

class HomeController extends Controller
{
    public function index()
    {
        return view('front::pages.index');
    }

    public function configuration()
    {
        SEOMeta::setTitle('Configuration');

        $service = MarkdownService::generate('configuration.md');
        $content = $service->convertToHtml();
        $date = $service->date;

        $entities = [
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
                'count' => TagExtend::count(),
            ],
        ];
        $entities = json_decode(json_encode($entities));

        $config = [
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
            'http.pool_limit',
        ];
        $config = json_decode(json_encode($config));

        $env = [
            'php' => PHP_VERSION,
            'laravel' => Application::VERSION,
        ];

        return view('front::pages.configuration', compact('entities', 'config', 'env', 'content'));
    }

    public function license()
    {
        $license = File::get(base_path('LICENSE'));
        $license = str_replace("\n", '<br>', $license);

        return view('front::pages.license', compact('license'));
    }
}
