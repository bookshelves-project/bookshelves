<?php

namespace App\Jobs;

use App\Engines\Book\BookUtils;
use App\Engines\Book\Converter\Modules\AuthorModule;
use App\Facades\Bookshelves;
use App\Models\Audiobook;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\Language;
use App\Models\Library;
use App\Models\Serie;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Models\BookAuthor;
use Kiwilan\Ebook\Models\MetaTitle;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\SpatieMedia;

class AudiobookTrackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?string $bookName,
        public bool $fresh,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! $this->bookName) {
            Journal::error('AudiobookTrackJob', 'Book name is required.');

            return;
        }

        /** @var Collection<AudiobookTrack> $tracks */
        $tracks = AudiobookTrack::query()
            ->where('title', $this->bookName)
            ->get();
        $track = $tracks->first();

        $track->loadMissing('library');
        $library = $track->library;

        Book::withoutSyncingToSearch(function () use ($track, $tracks, $library) {
            $this->parseBook($track, $tracks, $library);
        });

    }

    /**
     * Parse the audiobook.
     *
     * @param  Collection<AudiobookTrack>  $tracks
     */
    private function parseBook(AudiobookTrack $track, Collection $tracks, Library $library): void
    {
        $meta = MetaTitle::fromData(
            title: $track->title,
            language: $track->language,
            series: $track->serie,
            volume: $track->volume,
            year: $track->publish_date?->year,
        );
        $book = Book::query()->create([
            'title' => $track->title,
            'slug' => $meta->getSlug(),
            'contributor' => $track->encoding,
            'released_on' => $track->publish_date,
            'description' => $track->description,
            'audiobook_narrators' => $track->narrators,
            'audiobook_chapters' => count($tracks),
            'rights' => $track->encoding,
            'volume' => $track->volume,
            'added_at' => $track->added_at,
        ]);

        $parsed_title = $this->parseTitle($track);
        if ($parsed_title) {
            $track->parsed_title = $parsed_title;
            $track->saveQuietly();

            $book->title = $parsed_title;
            $book->saveQuietly();
        }

        if ($track->tags) {
            $tags = collect();
            foreach ($track->tags as $tag) {
                $tag = Tag::query()->firstOrCreate([
                    'name' => $tag,
                ]);
                $tags->push($tag);
            }
            $book->tags()->syncWithoutDetaching($tags->pluck('id'));
            $book->saveQuietly();
        }

        $language = $this->parseLang($track);
        if ($language) {
            $book->language()->associate($language);
            $book->saveQuietly();
        } else {
            Journal::warning("AudiobookJob : Language not found for {$book->title}", [
                'audiobook' => $track->toArray(),
            ]);
        }

        if ($track->authors) {
            $authors = [];
            foreach ($track->authors as $author) {
                $authors[] = new BookAuthor($author, 'aut');
            }

            $authors = AuthorModule::toCollection($authors);
            $book->authors()->sync($authors->pluck('id'));
        }

        $serie = null;
        if ($track->serie) {
            $serie = Serie::query()->firstOrCreate([
                'title' => $track->serie,
                'slug' => $meta->getSeriesSlug(),
            ]);
            $serie->books()->save($book);
            $serie->library()->associate($library);
            $serie->language()->associate($language);
            $serie->saveQuietly();
        }

        $coverPath = BookUtils::audiobookTrackCoverPath($track);
        $contents = null;
        if (file_exists($coverPath)) {
            $contents = file_get_contents($coverPath);
        } else {
            Journal::warning("AudiobookJob : Cover not found for {$book->title}", [
                'audiobook' => $track->toArray(),
            ]);
        }

        if ($contents) {
            SpatieMedia::make($book)
                ->addMediaFromString($contents)
                ->name($book->slug)
                ->extension(Bookshelves::imageFormat())
                ->collection(Bookshelves::imageCollection())
                ->disk(Bookshelves::imageDisk())
                ->color()
                ->save();
        }

        // delete cover
        if (file_exists($coverPath)) {
            unlink($coverPath);
        }

        $book->audiobookTracks()->saveMany($tracks);
        $book->authorMain()->associate($book->authors[0] ?? null);
        $book->library()->associate($library);

        if ($serie) {
            /** @var Serie $serie */
            $serie->authors()->syncWithoutDetaching($book->authors->pluck('id'));
            if (! $serie->authorMain) {
                $serie->authorMain()->associate($book->authorMain);
            }
            $serie->save();
        }

        $book->saveQuietly();
    }

    private function parseTitle(?AudiobookTrack $track): ?string
    {
        if (! $track) {
            return null;
        }

        if (! str_contains($track->title, '#') && ! str_contains($track->title, ':')) {
            return $track->title;
        }

        // `La Quête d'Ewilan #01 : D'un monde à l'autre`
        // to `D'un monde à l'autre`
        if (preg_match('/#\d+ : (.*)/', $track->title, $matches)) {
            $result = $matches[1] ?? null;
            if ($result) {
                return trim($result);
            }
        }

        return $track->title;
    }

    private function parseLang(?AudiobookTrack $track): ?Language
    {
        if (! $track) {
            return null;
        }

        $lang = $track->language ?? $track->comment;
        $lang_slug = Str::slug($lang);

        foreach (Language::all() as $language) {
            if ($lang_slug === Str::slug($language->slug)) {
                return $language;
            }

            if ($lang_slug === Str::slug($language->name)) {
                return $language;
            }
        }

        return Language::query()->firstOrCreate([
            'name' => $lang,
            'slug' => Str::slug($lang),
        ]);
    }
}
