<?php

namespace App\View\Components\Webreader;

use Illuminate\View\Component;

class Navigation extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $route,
        public ?string $icon
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.webreader.navigation');
    }
}
