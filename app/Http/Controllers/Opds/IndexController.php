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
    #[Get('/', name: 'index')]
    public function index()
    {
        return Opds::make(
            config: OpdsApp::config(),
            feeds: OpdsApp::home(),
        )->response();
    }

    #[Get('/latest', name: 'latest')]
    public function latest()
    {
        $feeds = [];

        foreach (Book::query()->orderBy('updated_at', 'desc')->limit(32)->get() as $book) {
            $feeds[] = OpdsApp::bookToEntry($book);
        }

        return Opds::make(
            config: OpdsApp::config(),
            feeds: $feeds,
            title: 'Latest books',
        )->response();
    }

    #[Get('/random', name: 'random')]
    public function random()
    {
        $feeds = [];

        foreach (Book::query()->inRandomOrder()->limit(32)->get() as $book) {
            $feeds[] = OpdsApp::bookToEntry($book);
        }

        return Opds::make(
            config: OpdsApp::config(),
            feeds: $feeds,
            title: 'Random books',
        )->response();
    }

    #[Get('/search', name: 'search')]
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

        return Opds::make(
            config: OpdsApp::config(),
            feeds: $feeds,
            title: "Search for {$query}",
            // isSearch: true,
        )->response();
    }
}
