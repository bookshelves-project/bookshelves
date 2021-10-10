<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class Social extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title,
        public ?string $author
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layout.social');
    }
}
