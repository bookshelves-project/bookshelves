<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\BookTypeEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Book;
use App\Models\Serie;
use File;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Services\MediaService;

class SerieConverter
{
    protected ?Serie $serie = null;

    public const DISK = MediaDiskEnum::cover;

    /**
     * Set Serie from Ebook.
     */
    public static function toModel(Ebook $ebook, BookTypeEnum $type): self
    {
        $self = new self();
        $serie = Serie::whereSlug($ebook->metaTitle()->serieSlug())->first();

        if (! $serie && $ebook->series()) {
            $serie = Serie::firstOrCreate([
                'title' => $ebook->series(),
                'slug_sort' => $ebook->metaTitle()->serieSlugSort(),
                'slug' => $ebook->metaTitle()->serieSlugLang(),
                'type' => $type,
            ]);

            $self->serie = $serie;
        }

        return $self;
    }

    public function associate(?Book $book): ?Serie
    {
        if (! $this->serie || ! $book) {
            return null;
        }

        $this->serie->language()->associate($book->language);

        $authors = [];

        foreach ($this->serie->authors as $author) {
            $authors[] = $author->slug;
        }

        foreach ($book->authors as $key => $author) {
            if (! in_array($author->slug, $authors)) {
                $this->serie->authors()->save($author);
            }
        }

        $this->serie->save();

        return $this->serie;
    }

    /**
     * Set default cover from first `Book` of `Serie`.
     * Get `volume` `1` if exist.
     */
    public static function setBookCover(Serie $serie): Serie
    {
        $disk = self::DISK;

        if ($serie->getMedia($disk->value)->isEmpty()) {
            $book = Book::whereVolume(1)->whereSerieId($serie->id)->first();

            if (! $book) {
                $book = Book::whereSerieId($serie->id)->first();
            }

            /** @var Book $book */
            $cover_exist = File::exists($book->cover_book?->getPath());

            if ($cover_exist) {
                $cover = base64_encode(File::get($book->cover_book->getPath()));
                MediaService::make($serie, $serie->slug, $disk)
                    ->setMedia($cover)
                    ->setColor()
                ;
            }

            $serie->save();
        }

        return $serie;
    }
}
