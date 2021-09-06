<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class SidebarStatic extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?array $links
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.sidebar-static');
    }
}
