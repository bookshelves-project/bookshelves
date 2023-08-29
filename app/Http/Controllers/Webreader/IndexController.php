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
    #[Get('/{author}/{book}', name: 'webreader.reader')]
    public function reader(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereAuthorMainId($author->id)
            ->whereSlug($book)
            ->firstOrFail()
        ;

        $media = $book->file_main;
        $format = BookFormatEnum::from($media->format);

        $title = $book->title;
        $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        $title .= ' by '.$book->authors_names;

        /** @var MediaExtended $file */
        $file = $book->files[$format->value];
        $path = $file->getPath();
        $path = explode('storage/app/public/', $path)[1];
        $path = config('app.url')."/storage/{$path}";

        $data = [
            'title' => $book->title,
            'titleFull' => $title,
            'authors' => $book->authors_names,
            'series' => $book->serie ? "{$book->serie->title}, vol. {$book->volume}" : null,
            'volume' => $book->volume,
            // 'book_next' => $book_next?->title,
            // 'book_next_route' => $book_next_route,
            'filename' => $file->file_name,
            'url' => $file->download,
            'path' => $path,
            'downloadUrl' => route('api.download.book', [
                'author_slug' => $author->slug,
                'book_slug' => $book->slug,
                'format' => $format->value,
            ]),
            'format' => $format->value,
            'size' => $file->size_human,
        ];
        $book = json_encode($data);
        // $book = json_decode($data);

        return view('webreader::pages.epub', [
            'book' => $book,
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

        // SEOTools::setTitle($title);
        // SEOTools::setDescription(Str::limit($book->description, 150).'...');
        // SEOTools::addImages([$book->cover_simple]);

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
