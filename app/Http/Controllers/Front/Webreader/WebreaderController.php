<?php

namespace App\Http\Controllers\Front\Webreader;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('features/webreader')]
class WebreaderController extends Controller
{
    #[Get('/', name: 'front.webreader')]
    public function index()
    {
        SEOTools::setTitle('Webreader');

        $random_book = Book::inRandomOrder()->first();
        $cover = null;
        $route = null;
        $service = MarkdownService::generate('webreader/index.md');
        $content = $service->convertToHtml();
        if ($random_book) {
            $cover = $random_book->getCoverThumbnailAttribute();
            $route = route('front.webreader.reader', ['author' => $random_book->meta_author, 'book' => $random_book->slug]);
        }

        return view('front::pages.webreader.index', compact('random_book', 'cover', 'route', 'content'));
    }

    #[Get('/{author}/{book}/{page?}', name: 'front.webreader.reader')]
    public function reader(string $author, string $book, ?string $page = null)
    {
        // $author = Author::whereSlug($author)->firstOrFail();
        // $book = Book::whereRelation('authors', 'name', '=', $author->name)->whereSlug($book)->firstOrFail();
        // $epub = $book->getFirstMediaUrl('epub');
        // $epub_download = $epub;
        // $epub_path = str_replace(config('app.url'), '', $epub);

        // $title = $book->title;
        // $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        // $title .= ' by '.$book->authors_names;

        // $book = BookResource::make($book);
        // $book = json_decode($book->toJson());

        // return view('pages.features.webreader.reader', compact('epub_path', 'epub_download', 'book', 'title'));

        return Inertia::render('Reader');
    }
}
