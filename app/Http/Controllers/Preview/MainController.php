<?php

namespace App\Http\Controllers\Preview;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class MainController extends Controller
{
    #[Get('/{type}/{id}', name: 'social.preview')]
    public function show(Request $request, string $type, string|int $id)
    {
        $class = match ($type) {
            'book' => Book::class,
            'author' => Author::class,
            'serie' => Serie::class,
            default => null,
        };

        /** @var Book|Author|Serie */
        $media = $class::where('id', $id)->first();

        if (! $media) {
            abort(404);
        }

        if ($media instanceof Book) {
            $media->loadMissing(['library', 'media', 'serie', 'language', 'authors']);
        } elseif ($media instanceof Author) {
            $media->loadMissing(['books', 'series', 'media'])
                ->loadCount(['books', 'series']);
        } elseif ($media instanceof Serie) {
            $media->loadMissing(['library', 'media', 'authors', 'books', 'language'])
                ->loadCount(['books']);
        }

        $title = match ($type) {
            'book' => $media->title,
            'author' => $media->name,
            'serie' => $media->title,
            default => 'Media',
        };
        $poster = match ($type) {
            'book' => $media->cover_standard,
            'author' => $media->cover_standard,
            'serie' => $media->cover_standard,
            default => null,
        };
        $og_image = match ($type) {
            'book' => $media->cover_social,
            'author' => $media->cover_social,
            'serie' => $media->cover_social,
            default => null,
        };
        $description = match ($type) {
            'book' => $media->description,
            'author' => "{$media->name} is the author of {$media->books_count} book".($media->books_count > 1 ? 's' : '')." and {$media->series_count} serie".($media->series_count > 1 ? 's' : '').' on Bookshelves.',
            'serie' => $media->description,
            default => null,
        };

        $extra = match ($type) {
            'book' => $media->has_series ? "{$media->serie->title} #{$media->volume_pad} | {$media->library->type_label}" : "{$media->library->type_label}",
            'serie' => "{$media->books_count} book".($media->books_count > 1 ? 's' : '')." | {$media->library->type_label}",
            'author' => ($media->books_count ? "{$media->books_count} book".($media->books_count > 1 ? 's' : '') : null)
                        .($media->books_count && $media->series_count ? ' | ' : '')
                        .($media->series_count ? "{$media->series_count} serie".($media->series_count > 1 ? 's' : '') : null),
            default => null,
        };

        $media_url = match ($type) {
            'book' => route('books.show', ['library' => $media->library?->slug, 'book' => $media->slug]),
            'serie' => route('series.show', ['library' => $media->library?->slug, 'serie' => $media->slug]),
            'author' => route('authors.show', ['author' => $media->slug]),
            default => null,
        };
        $type_label = match ($type) {
            'book' => 'Book',
            'author' => 'Author',
            'serie' => 'Serie',
            default => null,
        };

        $tagline = match ($type) {
            'book' => $media->has('authors') ? 'By '.$media->authors->pluck('name')->join(', ') : null,
            'author' => null,
            'serie' => $media->has('authors') ? 'By '.$media->authors->pluck('name')->join(', ') : null,
            default => null,
        };

        $description = strip_tags($description);
        $description = strlen($description) > 250
                ? substr($description, 0, 247).'...'
                : $description;

        $language = match ($type) {
            'book' => $media->language?->name,
            'author' => null,
            'serie' => $media->language?->name,
            default => null,
        };

        return response()->view('preview.index', [
            'title_page' => "{$title} on Bookshelves",
            'title' => $title,
            'description' => $description,
            'image' => $poster,
            'og_image' => $og_image,
            'preview_url' => route('social.preview', ['type' => $type, 'id' => $id]),
            'media_url' => $media_url,
            'type' => $type_label,
            'extra' => $extra,
            'language' => $language,
            'tagline' => $tagline,
        ]);
    }
}
