<?php

namespace App\Http\Controllers;

use App\Enums\LibraryTypeEnum;
use App\Facades\Bookshelves;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\Download;
use App\Models\Serie;
use App\Utils\NitroStream;
use Illuminate\Support\Str;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\Downloader\Downloader;
use Kiwilan\Steward\Utils\Downloader\DownloaderZipStreamItem;

class DownloadBaseController extends Controller
{
    protected function checkIfExists(Book $book): void
    {
        if (! file_exists($book->file->path)) {
            Journal::warning("File not found at {$book->file->path}")->toNotifier('discord');
        }
    }

    protected function downloadBook(Book $book)
    {
        $name = NitroStream::clearSpaces("{$book->getHumanNameAttribute()}");

        if ($book->is_audiobook) {
            $files = $book->audiobookTracks
                ->map(fn (AudiobookTrack $track) => new DownloaderZipStreamItem($track->file->basename, $track->file->path))
                ->toArray();

            Downloader::stream($name)
                ->files($files)
                ->get();

            return;
        }

        Downloader::direct($book->file->path)
            ->name("{$name}.{$book->file->extension}")
            ->mimeType($book->file->mime_type)
            ->get();
    }

    protected function downloadSerie(Serie $serie)
    {
        $files = [];
        $serie->loadMissing(['books', 'library']);

        if ($serie->library->type !== LibraryTypeEnum::audiobook) {
            $files = $serie->books
                ->map(fn (Book $book) => new DownloaderZipStreamItem("{$book->slug}.{$book->file->extension}", $book->file->path))
                ->toArray();
        } else {
            $files = $this->handleAudioSeries($serie, $files);
        }

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
    protected function validIP(string $ip): bool
    {
        $limit = Bookshelves::limitDownloads();
        if (! $limit) {
            return true;
        }

        $ipsPattern = Bookshelves::ipsBlockedPattern();
        foreach ($ipsPattern as $pattern) {
            if (Str::startsWith($ip, $pattern)) {
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

    private function handleAudioSeries(Serie $serie, array $files): array
    {
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

        return $files;
    }
}
