<?php

namespace App\Http\Controllers\Opds;

use App\Enums\LibraryTypeEnum;
use App\Facades\OpdsSetup;
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
        OpdsSetup::app()
            ->feeds(OpdsSetup::home())
            ->send();
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
            $feeds[] = OpdsSetup::bookToEntry($book);
        }

        OpdsSetup::app()
            ->title('Latest books')
            ->feeds($feeds)
            ->send();
    }

    #[Get('/random', name: 'opds.random')]
    public function random()
    {
        $feeds = [];

        $entries = Book::query()
            ->inRandomOrder()
            ->whereLibraryType(LibraryTypeEnum::book)
            ->limit(1)
            ->get();

        foreach ($entries as $book) {
            $feeds[] = OpdsSetup::bookToEntry($book);
        }

        OpdsSetup::app()
            ->title('Random book')
            ->feeds($feeds)
            ->send();
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
                $book->loadMissing('library');
                if ($book->library->type !== LibraryTypeEnum::book) {
                    continue;
                }
                $feeds[] = OpdsSetup::bookToEntry($book);
            }
        }

        OpdsSetup::app()
            ->title("Search for {$query}")
            ->isSearch()
            ->feeds($feeds)
            ->send();
    }
}
