<?php

namespace App\Engines\Opds\Config;

use DateTime;

class OpdsEntryBook
{
    /**
     * @param  OpdsEntryBookAuthor[]  $authors
     */
    public function __construct(
        public string $id,
        public string $title,
        public ?string $content = null,
        public ?DateTime $updated = null,
        public ?string $routeSelf = null,
        public ?string $routeDownload = null,
        public ?string $media = null,
        public ?string $mediaThumbnail = null,
        public array $categories = [],
        public array $authors = [],
        public ?DateTime $published = null,
        public ?int $volume = null,
        public ?string $serie = null,
        public ?string $language = null,
    ) {
        if ($content) {
            $this->content = strlen($this->content) > 500 ? substr($this->content, 0, 500).'...' : $this->content;
        }
    }
}

class OpdsEntryBookAuthor
{
    public function __construct(
        public string $name,
        public ?string $uri = null,
    ) {
    }
}
