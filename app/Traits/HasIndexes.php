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

    private function getIndexPath(string $type): string
    {
        $this->loadMissing('library');

        return BookshelvesUtils::getIndexPath(folder: $type, filename: $this->id, subfolder: $this->library->slug);
    }
}
