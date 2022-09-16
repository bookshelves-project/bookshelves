<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class Front extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $title = null,
        public bool $prose = true,
        public bool $features = true,
        public bool $developer = true,
        public string $prose_class = 'prose prose-lg dark:prose-invert prose-headings:font-handlee prose-headings:font-medium',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layout.front');
    }
}
