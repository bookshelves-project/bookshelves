<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $navigation = [
            [
                'title' => 'Authors',
                'route' => 'front.catalog.authors',
            ],
            [
                'title' => 'Series',
                'route' => 'front.catalog.series',
            ],
        ];

        return view('components.catalog.navbar', compact('navigation'));
    }
}
