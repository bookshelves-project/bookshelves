<?php

namespace App\View\Components\Field;

use Illuminate\View\Component;

class UploadFile extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $name = 'file',
        public ?string $label = null,
        public bool $multiple = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.field.upload-file');
    }
}
