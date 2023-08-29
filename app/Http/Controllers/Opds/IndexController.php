<?php

namespace App\Http\Controllers\Opds;

use App\Engines\OpdsApp;
use App\Engines\SearchEngine;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Kiwilan\Opds\Opds;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('/')]
class IndexController extends Controller
{
    #[Get('/', name: 'opds.json')]
    public function json()
    {
        return Opds::make(OpdsApp::config())
            ->response()
        ;
    }

    #[Get('/', name: 'opds.index')]
    public function index()
    {
        return Opds::make(OpdsApp::config())
            ->feeds(OpdsApp::home())
            ->response()
        ;
    }

    #[Get('/latest', name: 'opds.latest')]
    public function latest()
    {
        $feeds = [];

        foreach (Book::query()->orderBy('updated_at', 'desc')->limit(32)->get() as $book) {
            $feeds[] = OpdsApp::bookToEntry($book);
        }

        return Opds::make(OpdsApp::config())
            ->title('Latest books')
            ->feeds($feeds)
            ->response()
        ;
    }

    #[Get('/random', name: 'opds.random')]
    public function random()
    {
        $feeds = [];

        foreach (Book::query()->inRandomOrder()->limit(32)->get() as $book) {
            $feeds[] = OpdsApp::bookToEntry($book);
        }

        return Opds::make(OpdsApp::config())
            ->title('Random books')
            ->feeds($feeds)
            ->response()
        ;
    }

    #[Get('/search', name: 'opds.search')]
    public function search(Request $request)
    {
        $query = $request->input('q');
        $feeds = [];

        if ($query) {
            $search = SearchEngine::make(q: $query, relevant: false, opds: true, types: ['books']);

            foreach ($search->results_opds as $result) {
                /** @var Book $result */
                $feeds[] = OpdsApp::bookToEntry($result);
            }
        }

        return Opds::make(OpdsApp::config())
            ->title(title: "Search for {$query}")
            ->isSearch()
            ->feeds($feeds)
            ->response()
        ;
    }
}
