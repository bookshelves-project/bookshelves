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
#[Prefix('webreader')]
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
            $route = route('webreader.reader', ['author' => $random_book->meta_author, 'book' => $random_book->slug]);
        }

        return view('front::pages.webreader.index', compact('random_book', 'cover', 'route', 'content'));
    }
}
