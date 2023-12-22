<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookFormatEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('download')]
class DownloadController extends Controller
{
    /**
     * GET Book.
     *
     * <small class="badge badge-green">Content-Type application/epub+zip</small>
     *
     * Download Book format like `epub` or `cbz`.
     *
     * @header Content-Type application/epub+zip
     */
    #[Get('/book/{author_slug}/{book_slug}', name: 'api.download.book')]
    public function index(Request $request, Author $author, Book $book)
    {
        if ($format = $request->get('format')) {
            $format = BookFormatEnum::from($format);
        } else {
            $media = $book->file_main;
            $format = BookFormatEnum::from($media->format);
        }
        $format = $this->getFormat($book, $format->value);

        if ($format === null) {
            return response()->json([
                'message' => 'Have not any format available.',
            ], 404);
        }

        $media = $book->files[$format];

        if ($media === null) {
            return response()->json([
                'message' => "Have not {$format} format available.",
            ], 404);
        }

        return response()->download($media->getPath(), $media->file_name, disposition: 'inline');
    }

    #[Get('/book/direct/{author_slug}/{book_slug}', name: 'api.download.direct')]
    public function direct(Request $request, Author $author, Book $book)
    {
        $path = $book->physical_path;
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return response()->download($path, "{$book->slug_sort}.{$extension}", disposition: 'inline');
    }

    /**
     * GET Book[] belongs to Author.
     *
     * <small class="badge badge-green">Content-Type application/octet-stream</small>
     *
     * Download Author ZIP.
     *
     * @header Content-Type application/octet-stream
     */
    #[Get('/author/{author_slug}/{format?}', 'api.download.author')]
    public function author(Author $author, ?string $format = null)
    {
        $files = [];

        foreach ($author->books as $book) {
            $format = $this->getFormat($book, $format);

            if ($format) {
                $file = $book->getMedia($format)->first();

                if ($file) {
                    array_push($files, $file);
                }
            }
        }

        if (count($files) === 0) {
            return response()->json([
                'message' => "Have not {$format} format available.",
            ], 404);
        }

        $token = Str::slug(Str::random(8));
        $dirname = "{$author->slug}-{$token}";

        return MediaStream::create("{$dirname}.zip")->addMedia($files);
    }

    /**
     * GET Book[] belongs to Serie.
     *
     * <small class="badge badge-green">Content-Type application/octet-stream</small>
     *
     * Download Serie ZIP.
     *
     * @header Content-Type application/octet-stream
     */
    #[Get('/serie/{author_slug}/{serie_slug}/{format?}', 'api.download.serie')]
    public function serie(Author $author, Serie $serie, ?string $format = null)
    {
        $files = [];

        foreach ($serie->books as $book) {
            $format = $this->getFormat($book, $format);

            if ($format) {
                $file = $book->getMedia($format)->first();

                if ($file) {
                    array_push($files, $file);
                }
            }
        }

        if (count($files) === 0) {
            return response()->json([
                'message' => "Have not {$format} format available.",
            ], 404);
        }

        $token = Str::slug(Str::random(8));
        $dirname = "{$serie->meta_author}-{$serie->slug}-{$token}";

        return MediaStream::create("{$dirname}.zip")->addMedia($files);
    }

    private static function getFormat(Book $book, ?string $format = null): ?string
    {
        if ($format !== null) {
            $format = BookFormatEnum::tryFrom($format)->name;
        } else {
            foreach ($book->files as $format_name => $media) {
                if ($media !== null) {
                    $format = $format_name;
                }
            }
        }

        return $format;
    }
}
