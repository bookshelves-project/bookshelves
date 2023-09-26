<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\BookTypeEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Book;
use App\Models\Serie;
use File;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Tools\MetaTitle;
use Kiwilan\Steward\Services\MediaService;

class SerieConverter
{
    protected ?Serie $serie = null;

    public const DISK = MediaDiskEnum::cover;

    public static function make(?string $serie, MetaTitle $meta, BookTypeEnum $type): ?Serie
    {
        if (! $serie) {
            return null;
        }

        return new Serie([
            'title' => $serie,
            'slug_sort' => $meta->getSerieSlugSort(),
            'slug' => $meta->getSerieSlugLang(),
            'type' => $type,
        ]);
    }

    /**
     * Set Serie from Ebook.
     */
    public static function toModel(Ebook $ebook, BookTypeEnum $type): self
    {
        $self = new self();
        $serie = Serie::whereSlug($ebook->getMetaTitle()->getSerieSlug())->first();

        if (! $serie && $ebook->getSeries()) {
            $serie = Serie::firstOrCreate([
                'title' => $ebook->getSeries(),
                'slug_sort' => $ebook->getMetaTitle()->getSerieSlugSort(),
                'slug' => $ebook->getMetaTitle()->getSerieSlugLang(),
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

        $book->load('authors');

        foreach ($book->authors as $key => $author) {
            if (! in_array($author->slug, $authors)) {
                $this->serie->authors()->save($author);
            }
        }

        $this->serie->authorMain()->associate($book->authorMain);
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
                    ->setColor();
            }

            $serie->save();
        }

        return $serie;
    }
}
