<?php

namespace App\Engines\Book\Converter\Modules;

use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\Library;
use App\Models\Serie;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Models\MetaTitle;
use Kiwilan\Steward\Utils\SpatieMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SerieModule
{
    protected ?Serie $serie = null;

    public static function make(?string $serie, MetaTitle $meta, Library $library): ?Serie
    {
        if (! $serie) {
            return null;
        }

        $serie = new Serie([
            'title' => $serie,
            'slug' => $meta->getSeriesSlug(),
        ]);

        $serie->library()->associate($library);
        $serie->saveQuietly();

        return $serie;
    }

    /**
     * Set Serie from Ebook.
     */
    public static function toModel(Ebook $ebook, Library $library): self
    {
        $self = new self();
        $serie = Serie::query()
            ->where('slug', $ebook->getMetaTitle()->getSeriesSlug())
            ->where('library_id', $library->id)
            ->first();

        if ($serie) {
            $self->serie = $serie;

            Serie::withoutSyncingToSearch(function () use ($self) {
                $self->serie->api_parsed_at = null;
                $self->serie->saveQuietly();
            });

            return $self;
        }

        if ($ebook->getSeries()) {
            $serie = Serie::withoutSyncingToSearch(function () use ($ebook) {
                return Serie::query()
                    ->firstOrCreate([
                        'title' => $ebook->getSeries(),
                        'slug' => $ebook->getMetaTitle()->getSeriesSlug(),
                    ]);
            });

            $serie->library()->associate($library);
            $serie->saveQuietly();

            $self->serie = $serie;
        }

        return $self;
    }

    public function associate(?Book $book): ?Serie
    {
        if (! $this->serie || ! $book) {
            return null;
        }

        Serie::withoutSyncingToSearch(function () use ($book) {
            $this->serie->language()->associate($book->language);

            $authors = [];

            foreach ($this->serie->authors as $author) {
                $authors[] = $author->slug;
            }

            $book->load('authors');

            foreach ($book->authors as $key => $author) {
                if (! in_array($author->slug, $authors)) {
                    $this->serie->authors()->save($author);
                }
            }

            $this->serie->authorMain()->associate($book->authorMain);
            $this->serie->save();
        });

        return $this->serie;
    }

    /**
     * Set default cover from first `Book` of `Serie`.
     * Get `volume` `1` if exist.
     */
    public static function setBookCover(Serie $serie): Serie
    {
        $serie->deleteCover();

        $book = Book::whereVolume(1)
            ->where('serie_id', $serie->id)
            ->first();

        if (! $book) {
            $book = Book::query()
                ->where('serie_id', $serie->id)
                ->first();
        }

        /** @var Media|null $media */
        $media = $book->cover_media;
        if (! $media) {
            return $serie;
        }

        Serie::withoutSyncingToSearch(function () use ($serie, $media) {
            $file = $media->getPath();
            SpatieMedia::make($serie)
                ->addMediaFromString(file_get_contents($file))
                ->collection(Bookshelves::imageCollection())
                ->disk(Bookshelves::imageDisk())
                ->color()
                ->save();
        });

        return $serie;
    }
}
