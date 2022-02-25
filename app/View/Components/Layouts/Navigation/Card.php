<?php

namespace App\View\Components\Layouts\Navigation;

use Illuminate\View\Component;
use App\Services\ConverterService;

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
        $route = ConverterService::arrayToObject($this->card);

        return view('components.layouts.navigation.card', compact('route'));
    }
}
