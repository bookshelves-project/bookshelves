<?php

namespace App\View\Components\Configuration;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = 'Title',
        public string $label = 'Label',
        public string $value = 'Value',
        public ?array $table = [],
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.configuration.table');
    }
}
