<?php

namespace App\Enums;

use App\Bookshelves;
use Kiwilan\Steward\Traits\LazyEnum;

enum BookTypeEnum: string
{
    use LazyEnum;

    case audiobook = 'audiobook';

    case book = 'book';

    case comic = 'comic';

    case manga = 'manga';

    public function libraryPath(): ?string
    {
        $name = "{$this->value}s";

        return app(Bookshelves::class)->library()[$name];
    }

    public function jsonPath(): string
    {
        return match ($this) {
            self::audiobook => storage_path('app/audiobooks.json'),
            self::book => storage_path('app/books.json'),
            self::comic => storage_path('app/comics.json'),
            self::manga => storage_path('app/mangas.json'),
        };
    }
}
