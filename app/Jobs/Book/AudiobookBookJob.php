<?php

namespace App\Jobs\Book;

use App\Engines\Book\BookUtils;
use App\Engines\Book\Converter\Modules\AuthorModule;
use App\Facades\Bookshelves;
use App\Jobs\Author\AuthorJob;
use App\Jobs\Serie\SerieJob;
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

class AudiobookBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?AudiobookTrack $main = null;

    /**
     * Create a new job instance.
     *
     * @param  Collection<AudiobookTrack>  $tracks
     */
    public function __construct(
        public Collection $tracks,
        public Library $library,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->tracks->isEmpty()) {
            Journal::warning('AudiobookBookJob: no tracks detected');

            return;
        }

        $main = $this->tracks->first();
        if (! $main) {
            Journal::warning('AudiobookBookJob: no tracks detected');

            return;
        }

        $this->main = $main;

        if (! $this->main->title) {
            Journal::error('AudiobookBookJob: book title is required.');

            return;
        }

        $this->parseBook();
    }

    /**
     * Parse the audiobook.
     */
    private function parseBook(): void
    {
        $meta = MetaTitle::fromData(
            title: $this->main->title,
            language: $this->main->language,
            series: $this->main->serie,
            volume: $this->main->volume,
            year: $this->main->publish_date?->year,
        );
        $exists = Book::query()->where('slug', $meta->getSlug())->exists();

        if ($exists) {
            return;
        }

        $book = Book::query()->create([
            'title' => $this->main->title,
            'slug' => $meta->getSlug(),
            'contributor' => $this->main->encoding,
            'released_on' => $this->main->publish_date,
            'description' => $this->main->description,
            'audiobook_narrators' => $this->main->narrators,
            'audiobook_chapters' => $this->tracks->count(),
            'rights' => $this->main->encoding,
            'volume' => $this->main->volume,
            'added_at' => $this->main->added_at,
        ]);

        $parsed_title = $this->parseTitle($this->main);
        if ($parsed_title) {
            $this->main->parsed_title = $parsed_title;
            $this->main->saveQuietly();

            $book->title = $parsed_title;
            $book->saveWithoutSyncingToSearch();
        }

        if ($this->main->tags) {
            $tags = collect();
            foreach ($this->main->tags as $tag) {
                $tag = Tag::query()->firstOrCreate([
                    'name' => $tag,
                ]);
                $tags->push($tag);
            }
            $book->tags()->syncWithoutDetaching($tags->pluck('id'));
            $book->saveWithoutSyncingToSearch();
        }

        $language = $this->parseLang($this->main);
        if ($language) {
            $book->language()->associate($language);
            $book->saveWithoutSyncingToSearch();
        } else {
            Journal::warning("AudiobookBookJob: Language not found for {$book->title}", [
                'audiobook' => $this->main->toArray(),
            ]);
        }

        if ($this->main->authors) {
            $authors = [];
            foreach ($this->main->authors as $author) {
                $authors[] = new BookAuthor($author, 'aut');
            }

            $authors = AuthorModule::make($authors);
            $book->authors()->sync($authors->pluck('id'));
        }

        $serie = null;
        if ($this->main->serie) {
            $serie = Serie::query()->firstOrCreate([
                'title' => $this->main->serie,
                'slug' => $meta->getSeriesSlug(),
            ]);
            $serie->books()->save($book);
            $serie->library()->associate($this->library);
            $serie->language()->associate($language);
            $serie->saveWithoutSyncingToSearch();
        }

        $coverPath = BookUtils::audiobookTrackCoverPath($this->main);
        $contents = null;
        if (file_exists($coverPath)) {
            $contents = file_get_contents($coverPath);
        } else {
            Journal::warning("AudiobookBookJob: Cover not found for {$book->title}", [
                'audiobook' => $this->main->toArray(),
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

        $book->audiobookTracks()->saveMany($this->tracks);
        $book->authorMain()->associate($book->authors[0] ?? null);
        $book->library()->associate($this->library);

        if ($serie) {
            /** @var Serie $serie */
            $serie->authors()->syncWithoutDetaching($book->authors->pluck('id'));
            if (! $serie->authorMain) {
                $serie->authorMain()->associate($book->authorMain);
            }
            $serie->saveWithoutSyncingToSearch();
            SerieJob::dispatch($serie);
        }

        if ($book->authors->isNotEmpty()) {
            foreach ($book->authors as $author) {
                AuthorJob::dispatch($author);
            }
        }

        $book->saveWithoutSyncingToSearch();
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
