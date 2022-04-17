<?php

namespace App\View\Components\Webreader;

use Illuminate\View\Component;

class Action extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $icon,
        public ?string $action = 'false'
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.webreader.action');
    }
}
