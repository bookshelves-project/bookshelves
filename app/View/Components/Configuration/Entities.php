<?php

namespace App\View\Components\Configuration;

use Illuminate\View\Component;

class Entities extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $table
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.configuration.entities');
    }
}
