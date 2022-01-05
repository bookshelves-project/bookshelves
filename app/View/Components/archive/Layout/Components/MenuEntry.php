<?php

namespace App\View\Components\Layout\Components;

use Illuminate\View\Component;

class MenuEntry extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $link
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layout.components.menu-entry');
    }
}
