<?php

namespace App\Jobs;

use App\Engines\Book\Converter\BookConverter;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Facades\Bookshelves;
use App\Models\Audiobook;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Kiwilan\Steward\Utils\SpatieMedia;

class AudiobookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $bookSerie = null;

    public ?string $bookTitle = null;

    public ?int $bookVolume = null;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $serieName,
        public bool $fresh,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $audiobooks = Audiobook::query()
            ->where('serie', $this->serieName)
            ->get();

        $first = $audiobooks->first();
        $this->parseTitle($first->serie);

        $book = new Book([
            'title' => $this->bookTitle,
            'slug' => $first->slug,
            'contributor' => $first->encoding,
            'released_on' => $first->publish_date,
            'description' => $first->description,
            'audiobook_narrators' => $first->narrators,
            'audiobook_chapters' => count($audiobooks),
            'rights' => $first->stik,
            'volume' => $this->bookVolume,
            'type' => BookTypeEnum::audiobook,
            'format' => BookFormatEnum::fromExtension($first->extension),
            'added_at' => $first->comment,
        ]);

        Book::withoutSyncingToSearch(function () use ($book, $audiobooks) {
            $book->save();
            $book->audiobooks()->saveMany($audiobooks);
        });

        if ($first->authors) {
            foreach ($first->authors as $author) {
                $author = Author::query()->firstOrCreate([
                    'name' => $author,
                ]);
                $author->books()->attach($book);
            }
        }

        $serie = null;
        if ($this->bookSerie) {
            $serie = Serie::query()->firstOrCreate([
                'title' => $this->bookSerie,
                'slug' => Str::slug($this->bookSerie),
                'type' => BookTypeEnum::audiobook,
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

        Book::withoutSyncingToSearch(function () use ($book, $serie) {
            $book->save();

            $book->authorMain()->associate($book->authors[0] ?? null);
            $book->save();
            if ($serie) {
                $serie->authors()->saveMany($book->authors);
                $serie->authorMain()->associate($book->authorMain);
                $serie->save();
            }
        });
    }

    private function parseTitle(string $text): void
    {
        $regex = '/^(?:(?P<serie>.+?)\s(?P<volume>\d{2})\s-\s)?(?P<title>.+)$/';
        $matches = [];

        if (preg_match($regex, $text, $matches)) {
            $this->bookSerie = $matches['serie'] ?? null;
            $this->bookVolume = $matches['volume'] ? intval($matches['volume']) : null;
            $this->bookTitle = $matches['title'] ?? $text;

            return;
        }

        $this->bookTitle = $text;
    }
}
