<?php

namespace App\Http\Controllers\Webreader;

use App\Enums\BookFormatEnum;
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
    #[Get('/{author}/{book}/{format}/{page?}', name: 'webreader.reader')]
    public function reader(string $author, string $book, string $format, ?string $page = null)
    {
        $format = BookFormatEnum::from($format);
        $home = route('webreader.reader', [
            'author' => $author,
            'book' => $book,
            'format' => $format->value,
        ]);

        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereRelation('authors', 'name', '=', $author->name)->whereSlug($book)->firstOrFail();

        $title = $book->title;
        $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        $title .= ' by '.$book->authors_names;

        SEOTools::setTitle($book->title);
        $download_link = $book->getFirstMediaUrl($format->value);
        $file_path = str_replace(config('app.url'), '', $download_link);
        $current_format = $format->value;
        $data = ['file_path', 'download_link', 'book', 'current_format', 'title', 'home'];

        if (BookFormatEnum::epub === $format) {
            return view('webreader::pages.epub', compact($data));
        }
        if (BookFormatEnum::pdf === $format) {
            $pdf = $book->getFirstMedia(BookFormatEnum::pdf->value);

            return response()->download($pdf->getPath(), $pdf->file_name);
        }
        if (BookFormatEnum::cbz === $format || BookFormatEnum::cbr === $format) {
            return view('webreader::pages.cbz', compact($data));
        }

        return view('webreader::pages.not-ready', compact('download_link'));
    }
}
