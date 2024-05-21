<?php

namespace App\Http\Controllers\Opds;

use App\Enums\LibraryTypeEnum;
use App\Facades\OpdsBase;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Kiwilan\Steward\Engines\SearchEngine;
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
            ->send(true);
    }

    #[Get('/latest', name: 'opds.latest')]
    public function latest()
    {
        $feeds = [];

        $entries = Book::query()
            ->whereLibraryType(LibraryTypeEnum::book)
            ->orderBy('updated_at', 'desc')
            ->limit(16)
            ->get();

        foreach ($entries as $book) {
            $feeds[] = OpdsBase::bookToEntry($book);
        }

        OpdsBase::app()
            ->title('Latest books')
            ->feeds($feeds)
            ->send(true);
    }

    #[Get('/random', name: 'opds.random')]
    public function random()
    {
        $feeds = [];

        $entries = Book::query()
            ->inRandomOrder()
            ->whereLibraryType(LibraryTypeEnum::book)
            ->limit(16)
            ->get();

        foreach ($entries as $book) {
            $feeds[] = OpdsBase::bookToEntry($book);
        }

        OpdsBase::app()
            ->title('Random books')
            ->feeds($feeds)
            ->send(true);
    }

    #[Get('/search', name: 'opds.search')]
    public function search(Request $request)
    {
        $query = $request->input('q') ?? $request->input('query');
        $feeds = [];

        if ($query) {
            $search = SearchEngine::make($query, [Book::class])->get();
            foreach ($search->getResults()->first() as $book) {
                /** @var Book $book */
                $feeds[] = OpdsBase::bookToEntry($book);
            }
        }

        OpdsBase::app()
            ->title("Search for {$query}")
            ->isSearch()
            ->feeds($feeds)
            ->send(true);
    }
}
