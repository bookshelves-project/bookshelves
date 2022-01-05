<?php

namespace App\View\Components\Layouts\Navigation;

use App\Services\FileService;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $card = [],
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $route = FileService::arrayToObject($this->card);

        return view('components.layouts.navigation.card', compact('route'));
    }
}
