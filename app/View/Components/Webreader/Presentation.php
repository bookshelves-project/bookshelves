<?php

namespace App\View\Components\Webreader;

use App\Models\Book;
use Illuminate\View\Component;

class Presentation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Book $book,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.webreader.presentation');
    }
}
