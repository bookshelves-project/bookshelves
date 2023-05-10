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
        return Opds::response(
            config: OpdsApp::config(),
            entries: OpdsApp::home(),
        );
    }

    #[Get('/latest', name: 'latest')]
    public function latest()
    {
        $entries = [];

        foreach (Book::orderBy('updated_at', 'desc')->limit(32)->get() as $book) {
            $entries[] = OpdsApp::bookToEntry($book);
        }

        return Opds::response(
            config: OpdsApp::config(),
            entries: $entries,
            title: 'Latest books',
        );
    }

    #[Get('/random', name: 'random')]
    public function random()
    {
        $entries = [];

        foreach (Book::inRandomOrder()->limit(32)->get() as $book) {
            $entries[] = OpdsApp::bookToEntry($book);
        }

        return Opds::response(
            config: OpdsApp::config(),
            entries: $entries,
            title: 'Random books',
        );
    }

    #[Get('/search', name: 'search')]
    public function search(Request $request)
    {
        $query = $request->input('q');
        $entries = [];

        if ($query) {
            $search = SearchEngine::make(q: $query, relevant: false, opds: true, types: ['books']);

            foreach ($search->results_opds as $result) {
                /** @var Book $result */
                $entries[] = OpdsApp::bookToEntry($result);
            }
        }

        return Opds::response(
            config: OpdsApp::config(),
            entries: $entries,
            title: "Search for {$query}",
            isSearch: true,
        );
    }
}
