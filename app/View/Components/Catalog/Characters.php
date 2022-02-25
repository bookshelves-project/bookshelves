<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class Characters extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $entities,
        public string $route,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $entities = $this->entities;

        return view('components.catalog.characters', compact('entities'));
    }
}
