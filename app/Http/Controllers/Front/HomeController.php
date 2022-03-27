<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\File;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'front.home')]
    public function index()
    {
        $service = MarkdownService::generate('welcome.md');
        $welcome = $service->convertToHtml();

        $service = MarkdownService::generate('developers.md');
        $developers = $service->convertToHtml();

        return view('front::pages.index', compact('welcome', 'developers'));
    }

    #[Get('/webreader', name: 'front.webreader')]
    public function webreader()
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

        return view('front::pages.webreader', compact('random_book', 'cover', 'route', 'content'));
    }
}
