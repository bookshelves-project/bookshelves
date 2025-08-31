<?php

namespace App\Traits;

use App\Engines\BookshelvesUtils;

trait HasIndexes
{
    public function getIndexBookPath(): string
    {
        return $this->getIndexPath('book');
    }

    public function getIndexAuthorPath(): string
    {
        return $this->getIndexPath('author');
    }

    public function getIndexSeriePath(): string
    {
        return $this->getIndexPath('serie');
    }

    public function getIndexTagPath(): string
    {
        return $this->getIndexPath('tag');
    }

    public function getIndexLanguagePath(): string
    {
        return $this->getIndexPath('language');
    }

    public function getIndexPublisherPath(): string
    {
        return $this->getIndexPath('publisher');
    }

    public function getIndexCoverPath(): string
    {
        return $this->getIndexPath('cover', 'jpg');
    }

    private function getIndexPath(string $type, string $extension = 'dat'): string
    {
        $this->loadMissing('library');
        $subfolder = $this->library?->slug ?? 'unknown';

        return BookshelvesUtils::getIndexPath(folder: $type, filename: $this->id, subfolder: $subfolder, extension: $extension);
    }
}
