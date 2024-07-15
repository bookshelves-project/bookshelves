<?php

namespace App\Http\Controllers\Api;

use App\Enums\LibraryTypeEnum;
use App\Facades\Bookshelves;
use App\Http\Controllers\Controller;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\Download;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\Downloader\Downloader;
use Kiwilan\Steward\Utils\Downloader\DownloaderZipStreamItem;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('downloads')]
class DownloadController extends Controller
{
    #[Get('/book/{book:id}', name: 'api.downloads.book')]
    public function book(Request $request, Book $book)
    {
        $this->validIP($request->ip());

        $name = '';
        $serie = $book->serie?->name ?? '';
        $volume = $book->volume ?? '';
        if ($serie) {
            $serie = Str::slug("{$serie}-{$volume}");
            $name = $serie;
        }
        $author = $book->authorMain?->name ?? '';
        $book->loadMissing(['library', 'audiobookTracks']);

        Download::generate($request, $book);

        $name = Str::slug("{$name} {$book->slug} {$author} {$book->library?->name}");
        if ($book->library?->type->isAudiobook()) {
            $files = $book->audiobookTracks
                ->map(fn (AudiobookTrack $track) => new DownloaderZipStreamItem($track->file->basename, $track->file->path))
                ->toArray();

            Downloader::stream($name)
                ->files($files)
                ->get();

            return;
        }

        Downloader::direct($book->file->path)
            ->mimeType($book->file->mime_type)
            ->name("{$name}.{$book->file->extension}")
            ->get();
    }

    #[Get('/serie/{serie:id}', name: 'api.downloads.serie')]
    public function serie(Request $request, Serie $serie)
    {
        $this->validIP($request->ip());

        $files = [];
        $serie->loadMissing(['books', 'library']);

        if ($serie->library->type !== LibraryTypeEnum::audiobook) {
            $files = $serie->books
                ->map(fn (Book $book) => new DownloaderZipStreamItem("{$book->slug}.{$book->file->extension}", $book->file->path))
                ->toArray();
        } else {
            foreach ($serie->books as $book) {
                $book->load('audiobookTracks');
                $tracks = $book->audiobookTracks;
                $files = array_merge(
                    $files,
                    $tracks
                        ->map(function (AudiobookTrack $track) use ($book) {
                            $name = Str::slug("{$book->title}").'.'.$track->file->basename;

                            return new DownloaderZipStreamItem($name, $track->file->path);
                        })
                        ->toArray()
                );
            }
        }

        Download::generate($request, $serie);

        $name = Str::slug("{$serie->slug}-".$serie->books->count().'-books');
        Downloader::stream($name)
            ->files($files)
            ->get();
    }

    /**
     * Check if the IP is valid to download.
     *
     * Allow 10 downloads per 24 hours.
     */
    private function validIP(string $ip): bool
    {
        $limit = Bookshelves::limitDownloads();
        if (! $limit) {
            return true;
        }

        $startsWith = Bookshelves::ipsBlockedStartsWith();
        foreach ($startsWith as $start) {
            if (Str::startsWith($ip, $start)) {
                abort(403, 'Forbidden');
            }
        }

        $downloads = Download::query()->where('ip', $ip)
            ->where('created_at', '>=', now()->subDay())
            ->count();

        if ($downloads >= $limit) {
            abort(429, 'Too many requests');
        }

        return true;
    }
}
