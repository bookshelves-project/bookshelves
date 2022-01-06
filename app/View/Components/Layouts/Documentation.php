<?php

namespace App\View\Components\layouts;

use Illuminate\View\Component;

class Documentation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?object $links = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layouts.documentation');
    }
}
