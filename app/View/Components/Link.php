<?php

namespace App\View\Components;

use App\Services\ConverterService;
use Illuminate\View\Component;

class Link extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $array = [],
        public ?object $object = null,
        public ?bool $title = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $link = ConverterService::arrayToObject([
            'route' => '',
            'href' => false,
            'title' => 'Default',
            'description' => '',
            'icon' => null,
            'external' => false,
        ]);
        if (! empty($this->array)) {
            $link = ConverterService::arrayToObject($this->array);
        } elseif (! empty($this->object)) {
            $link = $this->object;
        }

        return view('components.link', compact('link'));
    }
}
