<?php

namespace App\Http\Controllers\Opds;

use App\Engines\SearchEngine;
use App\Facades\OpdsBase;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('/')]
class IndexController extends Controller
{
    #[Get('/', name: 'opds.index')]
    public function index()
    {
        OpdsBase::app()
            ->feeds(OpdsBase::home())
            ->send(config('app.env') === 'local');
    }

    #[Get('/latest', name: 'opds.latest')]
    public function latest()
    {
        $feeds = [];

        $entries = Book::query()
            ->whereIsBook()
            ->orderBy('updated_at', 'desc')
            ->limit(16)
            ->get();

        foreach ($entries as $book) {
            $feeds[] = OpdsBase::bookToEntry($book);
        }

        OpdsBase::app()
            ->title('Latest books')
            ->feeds($feeds)
            ->send(config('app.env') === 'local');
    }

    #[Get('/random', name: 'opds.random')]
    public function random()
    {
        $feeds = [];

        $entries = Book::query()
            ->inRandomOrder()
            ->whereIsBook()
            ->limit(16)
            ->get();

        foreach ($entries as $book) {
            $feeds[] = OpdsBase::bookToEntry($book);
        }

        OpdsBase::app()
            ->title('Random books')
            ->feeds($feeds)
            ->send(config('app.env') === 'local');
    }

    #[Get('/search', name: 'opds.search')]
    public function search(Request $request)
    {
        $query = $request->input('q') ?? $request->input('query');
        $feeds = [];

        if ($query) {
            $search = SearchEngine::make(q: $query, relevant: false, opds: true, types: ['books']);

            foreach ($search->results_opds as $result) {
                /** @var Book $result */
                $feeds[] = OpdsBase::bookToEntry($result);
            }
        }

        OpdsBase::app()
            ->title("Search for {$query}")
            ->isSearch()
            ->feeds($feeds)
            ->send(config('app.env') === 'local');
    }
}
