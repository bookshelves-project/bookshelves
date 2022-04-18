<?php

namespace App\Http\Controllers\Webreader;

use App\Enums\BookFormatEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\MediaExtended;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
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
    #[Get('/{author}/{book}', name: 'webreader.reader')]
    public function reader(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereRelation('authors', 'name', '=', $author->name)->whereSlug($book)->firstOrFail();

        $home = route('webreader.reader', [
            'author' => $author,
            'book' => $book,
        ]);

        if ($format = $request->get('format')) {
            $format = BookFormatEnum::from($format);
        } else {
            $media = $book->file_main;
            $format = BookFormatEnum::from($media->format);
        }

        $title = $book->title;
        $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        $title .= ' by '.$book->authors_names;

        SEOTools::setTitle($book->title);
        /** @var MediaExtended $file */
        $file = $book->files[$format->value];

        $download_link = $book->getFirstMediaUrl($format->value);
        $full_download = $download_link;
        $file_path = str_replace(config('app.url'), '', $download_link);
        $current_format = $format->value;
        $data = ['file_path', 'download_link', 'full_download', 'file', 'book', 'current_format', 'title', 'home'];

        if (BookFormatEnum::epub === $format) {
            return view('webreader::pages.epub', compact($data));
        }
        if (BookFormatEnum::pdf === $format) {
            $pdf = $book->getFirstMedia(BookFormatEnum::pdf->value);

            return response()->download($pdf->getPath(), $pdf->file_name);
        }
        if (BookFormatEnum::cbz === $format || BookFormatEnum::cbr === $format) {
            return view('webreader::pages.comic', compact($data));
        }

        return view('webreader::pages.not-ready', compact('download_link'));
    }
}
