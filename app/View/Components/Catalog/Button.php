<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $route = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.catalog.button');
    }
}
