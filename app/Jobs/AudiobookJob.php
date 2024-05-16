<?php

namespace App\Jobs;

use App\Engines\Book\Converter\BookConverter;
use App\Enums\BookFormatEnum;
use App\Enums\LibraryTypeEnum;
use App\Facades\Bookshelves;
use App\Models\Audiobook;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Serie;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\SpatieMedia;

class AudiobookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public ?string $bookSerie = null;

    // public ?string $bookTitle = null;

    // public ?int $bookVolume = null;

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
        $first = $audiobooks->first();
        // $this->parseTitle($first->serie);

        $first->loadMissing('library');
        $library = $first->library;

        $book = Book::create([
            'title' => $first->title,
            'slug' => $first->slug,
            'contributor' => $first->encoding,
            'released_on' => $first->publish_date,
            'description' => $first->description,
            'audiobook_narrators' => $first->narrators,
            'audiobook_chapters' => count($audiobooks),
            'rights' => $first->encoding,
            'volume' => $first->volume,
            'format' => BookFormatEnum::fromExtension($first->extension),
            'size' => $audiobooks->sum('size'),
            'added_at' => $first->added_at,
        ]);

        if ($first->tags) {
            $tags = collect();
            foreach ($first->tags as $tag) {
                $tag = Tag::query()->firstOrCreate([
                    'name' => $tag,
                ]);
                $tags->push($tag);
            }
            $book->tags()->syncWithoutDetaching($tags->pluck('id'));
        }

        $lang = $first->language ?? $first->comment;
        if ($lang) {
            $language = Language::firstOrCreate([
                'name' => $lang,
                'slug' => Str::slug($lang),
            ]);
            $book->language()->associate($language);
        }

        if ($first->authors) {
            foreach ($first->authors as $author) {
                $author = Author::query()->firstOrCreate([
                    'name' => $author,
                ]);
                $author->books()->attach($book);
            }
        }

        $serie = null;
        if ($first->serie) {
            $slug = Str::slug($first->serie.' '.LibraryTypeEnum::audiobook->value.' '.$book->language?->name);
            $serie = Serie::query()->firstOrCreate([
                'title' => $first->serie,
                'slug' => $slug,
            ]);
            $serie->books()->save($book);
        }

        $cover = BookConverter::audiobookCoverPath($first);
        $contents = file_get_contents($cover);

        SpatieMedia::make($book)
            ->addMediaFromString($contents)
            ->name($book->slug)
            ->extension(Bookshelves::imageFormat())
            ->collection(Bookshelves::imageCollection())
            ->disk(Bookshelves::imageDisk())
            ->color()
            ->save();

        Book::withoutSyncingToSearch(function () use ($audiobooks, $book, $serie, $library) {
            $book->audiobooks()->saveMany($audiobooks);
            $book->authorMain()->associate($book->authors[0] ?? null);
            $book->library()->associate($library);
            $book->save();

            if ($serie) {
                /** @var Serie $serie */
                $serie->authors()->syncWithoutDetaching($book->authors->pluck('id'));
                if (! $serie->authorMain) {
                    $serie->authorMain()->associate($book->authorMain);
                }
                $serie->save();
            }
        });
    }

    // private function parseTitle(?string $text): void
    // {
    //     if (! $text) {
    //         return;
    //     }

    //     $regex = '/^(?:(?P<serie>.+?)\s(?P<volume>\d{2})\s[-:]\s)?(?P<title>.+)$/';
    //     $matches = [];

    //     if (preg_match($regex, $text, $matches)) {
    //         $this->bookSerie = $matches['serie'] ?? null;
    //         $this->bookVolume = $matches['volume'] ? intval($matches['volume']) : null;
    //         $this->bookTitle = $matches['title'] ?? $text;

    //         return;
    //     }

    //     $this->bookTitle = $text;
    // }

    // private function parseLang(string $lang): string
    // {
    //     $lang = strtolower($lang);

    //     return match ($lang) {
    //         'english' => 'en',
    //         'spanish' => 'es',
    //         'french' => 'fr',
    //         'german' => 'de',
    //         'italian' => 'it',
    //         'portuguese' => 'pt',
    //         'russian' => 'ru',
    //         'japanese' => 'ja',
    //         'chinese' => 'zh',
    //         default => 'en',
    //     };
    // }
}
