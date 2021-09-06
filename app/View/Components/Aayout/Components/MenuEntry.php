<?php

namespace App\View\Components\Layout\Components;

use Illuminate\View\Component;

class MenuEntry extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $link
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.components.menu-entry');
    }
}
