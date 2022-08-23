<?php

namespace App\View\Components\Catalog\Search;

use Illuminate\View\Component;

class Results extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $results,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.catalog.search.results');
    }
}
