<?php

namespace App\Http\Controllers\Webreader;

use App\Enums\BookFormatEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\MediaExtended;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
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
        $data = [
            'title' => $book->title,
            'full_title' => $title,
            'filename' => $file->file_name,
            'url' => $file->download,
            'download' => route('api.download.book', [
                'author_slug' => $author->slug,
                'book_slug' => $book->slug,
                'format' => $format->value,
            ]),
            'format' => $format->value,
            'size_human' => $file->size_human,
        ];
        $url = $data['url'];
        $data = json_encode($data);
        $book = json_decode($data);

        if (BookFormatEnum::epub === $format) {
            return view('webreader::pages.epub', compact('book'));
        }
        if (BookFormatEnum::pdf === $format) {
            $pdf = $book->getFirstMedia(BookFormatEnum::pdf->value);

            return response()->download($pdf->getPath(), $pdf->file_name);
        }
        if (BookFormatEnum::cbz === $format || BookFormatEnum::cbr === $format) {
            return view('webreader::pages.comic', compact('book'));
        }

        return view('webreader::pages.not-ready', compact('url'));
    }
}
