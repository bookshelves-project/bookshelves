<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class AttachmentUrl extends Field
{
    protected string $view = 'forms.components.attachment-url';

    protected ?string $prefix = null;

    public function prefix(?string $path = '/storage'): static
    {
        $this->prefix = $path;

        return $this;
    }

    public function getPrefix()
    {
        return $this->evaluate($this->prefix);
    }
}
