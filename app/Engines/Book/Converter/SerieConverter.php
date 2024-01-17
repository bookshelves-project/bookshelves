<?php

namespace App\Engines\Book\Converter;

use App\Engines\Book\Converter\Modules\SerieModule;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Support\Facades\File;
use Kiwilan\Steward\Services\MediaService;

/**
 * Improve Serie with additional data.
 */
class SerieConverter
{
    public function __construct(
        public Serie $serie,
    ) {
    }

    public static function make(Serie $serie): self
    {
        $self = new SerieConverter($serie);
        $self->setTags();
        $self->setCover();

        return $self;
    }

    // /**
    //  * Set cover placeholder if no cover.
    //  */
    // public function setCoverPlaceholder(): self
    // {
    //     if ($this->model->getMedia(MediaDiskEnum::cover->value)->isEmpty()) {
    //         $placeholder = public_path('vendor/images/no-author.webp');
    //         $disk = self::DISK;
    //         $this->model->clearMediaCollection($disk->value);
    //         MediaService::make($this->model, $this->model->slug, $disk)
    //             ->setMedia(base64_encode(File::get($placeholder)))
    //             ->setColor();
    //     }

    //     return $this;
    // }

    private function setCover(): self
    {
        SerieModule::setBookCover($this->serie);

        return $this;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    private function setTags(): self
    {
        $books = $this->serie->load('books.tags')->books;
        $tags = [];

        foreach ($books as $book) {
            foreach ($book->tags as $tag) {
                $tags[] = $tag->id;
            }
        }

        $tags = array_unique($tags);

        $this->serie->tags()->sync($tags);
        $this->serie->save();

        return $this;
    }
}
