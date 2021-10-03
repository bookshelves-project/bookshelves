<?php

namespace App\View\Components\Catalog;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Entities extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $entities,
        public string $type,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.catalog.entities');
    }
}
