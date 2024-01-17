<?php

namespace App\Engines\Book\Converter;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use Illuminate\Support\Facades\File;
use Kiwilan\Steward\Services\MediaService;

/**
 * Improve Author with additional data.
 */
class AuthorConverter
{
    public function __construct(
        public Author $author,
    ) {
    }

    public static function make(Author $author): self
    {
        $self = new AuthorConverter($author);

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
}
