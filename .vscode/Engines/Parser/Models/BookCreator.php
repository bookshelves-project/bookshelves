<?php

namespace App\Engines\Parser\Models;

class BookEntityAuthor
{
    protected function __construct(
        protected ?string $name = null,
        protected ?string $role = null,
    ) {
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function role(): ?string
    {
        return $this->role;
    }
}
