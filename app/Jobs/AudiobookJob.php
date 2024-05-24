<?php

namespace App\Jobs;

use App\Engines\Book\Converter\BookConverter;
use App\Enums\BookFormatEnum;
use App\Facades\Bookshelves;
use App\Models\Audiobook;
use App\Models\Author;
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
use Kiwilan\Ebook\Models\MetaTitle;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\SpatieMedia;

class AudiobookJob implements ShouldQueue
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
            Journal::error('AudiobookJob', 'Book name is required.');

            return;
        }

        $audiobooks = Audiobook::query()
            ->where('title', $this->bookName)
            ->get();
        $audiobook = $audiobooks->first();

        $audiobook->loadMissing('library');
        $library = $audiobook->library;

        Book::withoutSyncingToSearch(function () use ($audiobook, $audiobooks, $library) {
            $this->parseBook($audiobook, $audiobooks, $library);
        });

    }

    /**
     * Parse the audiobook.
     *
     * @param  Collection<Audiobook>  $audiobooks
     */
    private function parseBook(Audiobook $audiobook, Collection $audiobooks, Library $library): void
    {
        $meta = MetaTitle::fromData(
            title: $audiobook->title,
            language: $audiobook->language,
            series: $audiobook->serie,
            volume: $audiobook->volume,
            author: $audiobook->author_main,
            year: $audiobook->publish_date?->year,
            extension: $audiobook->extension,
        );
        $book = Book::query()->create([
            'title' => $audiobook->title,
            'slug' => $meta->getSlug(),
            'contributor' => $audiobook->encoding,
            'released_on' => $audiobook->publish_date,
            'description' => $audiobook->description,
            'audiobook_narrators' => $audiobook->narrators,
            'audiobook_chapters' => count($audiobooks),
            'rights' => $audiobook->encoding,
            'volume' => $audiobook->volume,
            'format' => BookFormatEnum::fromExtension($audiobook->extension),
            'size' => $audiobooks->sum('size'),
            'added_at' => $audiobook->added_at,
        ]);

        $parsed_title = $this->parseTitle($audiobook);
        if ($parsed_title) {
            $audiobook->parsed_title = $parsed_title;
            $audiobook->saveQuietly();

            $book->title = $parsed_title;
            $book->saveQuietly();
        }

        if ($audiobook->tags) {
            $tags = collect();
            foreach ($audiobook->tags as $tag) {
                $tag = Tag::query()->firstOrCreate([
                    'name' => $tag,
                ]);
                $tags->push($tag);
            }
            $book->tags()->syncWithoutDetaching($tags->pluck('id'));
            $book->saveQuietly();
        }

        $language = $this->parseLang($audiobook);
        if ($language) {
            $book->language()->associate($language);
            $book->saveQuietly();
        } else {
            Journal::warning("AudiobookJob : Language not found for {$book->title}", [
                'audiobook' => $audiobook->toArray(),
            ]);
        }

        if ($audiobook->authors) {
            foreach ($audiobook->authors as $author) {
                $author = Author::query()->firstOrCreate([
                    'name' => $author,
                ]);
                $author->books()->attach($book);
            }
        }

        $serie = null;
        if ($audiobook->serie) {
            $serie = Serie::query()->firstOrCreate([
                'title' => $audiobook->serie,
                'slug' => $meta->getSeriesSlug(),
            ]);
            $serie->books()->save($book);
            $serie->library()->associate($library);
            $serie->language()->associate($language);
            $serie->saveQuietly();
        }

        $cover = BookConverter::audiobookCoverPath($audiobook);
        $contents = file_get_contents($cover);

        SpatieMedia::make($book)
            ->addMediaFromString($contents)
            ->name($book->slug)
            ->extension(Bookshelves::imageFormat())
            ->collection(Bookshelves::imageCollection())
            ->disk(Bookshelves::imageDisk())
            ->color()
            ->save();

        $book->audiobooks()->saveMany($audiobooks);
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

    private function parseTitle(?Audiobook $audiobook): ?string
    {
        if (! $audiobook) {
            return null;
        }

        if (! str_contains($audiobook->title, '#') && ! str_contains($audiobook->title, ':')) {
            return $audiobook->title;
        }

        // `La Quête d'Ewilan #01 : D'un monde à l'autre`
        // to `D'un monde à l'autre`
        if (preg_match('/#\d+ : (.*)/', $audiobook->title, $matches)) {
            $result = $matches[1] ?? null;
            if ($result) {
                return trim($result);
            }
        }

        return $audiobook->title;
    }

    private function parseLang(?Audiobook $audiobook): ?Language
    {
        if (! $audiobook) {
            return null;
        }

        $lang = $audiobook->language ?? $audiobook->comment;
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
