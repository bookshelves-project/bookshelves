<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class SpatieMediaView extends Field
{
    protected string $view = 'forms.components.spatie-media-view';

    protected ?string $type = null;

    protected ?string $path = null;

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->evaluate($this->type);
    }

    public function path(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->evaluate($this->path);
    }
}
