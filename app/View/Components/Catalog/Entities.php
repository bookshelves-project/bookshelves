<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class Entities extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Collection $entities,
        public string $type,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.catalog.entities');
    }
}
