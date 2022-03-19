<?php

namespace App\Http\Controllers\Webreader;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Inertia\Inertia;
use Route;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('webreader')]
class WebreaderController extends Controller
{
    #[Get('/{author}/{book}/{page?}', name: 'webreader.reader')]
    public function reader(string $author, string $book, ?string $page = null)
    {
        $home = route('webreader.reader', [
            'author' => $author,
            'book' => $book,
        ]);

        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereRelation('authors', 'name', '=', $author->name)->whereSlug($book)->firstOrFail();
        $epub = $book->getFirstMediaUrl('epub');
        $download_link = $epub;
        $epub_path = str_replace(config('app.url'), '', $epub);

        $title = $book->title;
        $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        $title .= ' by '.$book->authors_names;

        // $book = BookResource::make($book);
        // $book = json_decode($book->toJson());

        SEOTools::setTitle($book->title);

        return view('webreader::pages.index', compact('epub_path', 'download_link', 'book', 'title', 'home'));

        // return Inertia::render('Reader');
        // return view('webreader::pages.index', compact('random_book', 'cover', 'route', 'content'));
    }
}
