<?php

namespace App\Http\Controllers\Webreader;

use App\Enums\BookFormatEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\MediaExtended;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * @hideFromAPIDocumentation
 */
class IndexController extends Controller
{
    #[Get('/{author}/{book}', name: 'reader')]
    public function reader(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorMainId($author->id)
            ->whereSlug($book)
            ->firstOrFail()
        ;

        return view('webreader::pages.epub', [
            'book' => $book,
            'url' => $book->file_main->url,
        ]);
        // $book_next = null;
        // $book_next_route = null;

        // if ($book->serie) {
        //     $volume = $book->volume;
        //     $books = $book->serie->books->filter(fn ($book) => $book->volume > intval($volume));

        //     $book_next = $books->first();
        //     $book_next_route = $book_next ? route('webreader.reader', [
        //         'author' => $book_next->meta_author,
        //         'book' => $book_next->slug,
        //     ]) : null;
        // }

        // $home = route('webreader.reader', [
        //     'author' => $author,
        //     'book' => $book,
        // ]);

        // if ($format = $request->get('format')) {
        //     $format = BookFormatEnum::from($format);
        // } else {
        //     $media = $book->file_main;
        //     $format = BookFormatEnum::from($media->format);
        // }

        // $title = $book->title;
        // $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        // $title .= ' by '.$book->authors_names;

        // SEOTools::setTitle($title);
        // SEOTools::setDescription(Str::limit($book->description, 150).'...');
        // SEOTools::addImages([$book->cover_simple]);

        // /** @var MediaExtended $file */
        // $file = $book->files[$format->value];
        // $data = [
        //     'title' => $book->title,
        //     'authors' => $book->authors_names,
        //     'serie' => $book->serie ? "{$book->serie->title}, vol. {$book->volume}" : null,
        //     'volume' => $book->volume,
        //     'book_next' => $book_next?->title,
        //     'book_next_route' => $book_next_route,
        //     'full_title' => $title,
        //     'filename' => $file->file_name,
        //     'url' => $file->download,
        //     'download' => route('api.download.book', [
        //         'author_slug' => $author->slug,
        //         'book_slug' => $book->slug,
        //         'format' => $format->value,
        //     ]),
        //     'format' => $format->value,
        //     'size_human' => $file->size_human,
        // ];
        // $url = $data['url'];
        // $data = json_encode($data);
        // $book = json_decode($data);

        // if (BookFormatEnum::epub === $format) {
        //     return view('webreader::pages.epubjs', ['book' => $book]);
        // }

        // if (BookFormatEnum::pdf === $format) {
        //     $pdf = $book->getFirstMedia(BookFormatEnum::pdf->value);

        //     return response()->download($pdf->getPath(), $pdf->file_name);
        // }

        // if (BookFormatEnum::cba === $format) {
        //     return view('webreader::pages.comic', ['book' => $book]);
        // }

        // return view('webreader::pages.not-ready', ['url' => $url]);
    }
}
