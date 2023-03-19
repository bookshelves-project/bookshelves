<?php

namespace App\Engines\Book\Parser\Parsers;

use App\Engines\Book\Parser\Modules\Interface\ParserModule;

abstract class BookParser
{
    public const IMAGE_FORMATS = ['jpg', 'jpeg'];

    /** @var array<string, mixed> */
    protected ?array $metadata = [];

    protected function __construct(
        protected ParserModule $module,
        protected string $name,
        protected string $path,
        protected ?string $cover = null,
        protected ?int $count = null,
    ) {
    }

    protected function setup(ParserModule $module): self
    {
        $this->module = $module;
        $this->path = $module->file()->path();
        $this->name = pathinfo($this->path, PATHINFO_FILENAME);

        return $this;
    }
}
