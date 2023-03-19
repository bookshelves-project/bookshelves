<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Link extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $data = [],
        public ?string $route = null,
        public ?array $routeParam = [],
        public ?string $href = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $icon = null,
        public ?bool $external = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (! empty($this->data)) {
            $this->route = array_key_exists('route', $this->data) ? $this->data['route'] : null;
            $this->routeParam = array_key_exists('routeParam', $this->data) ? $this->data['routeParam'] : [];
            $this->href = array_key_exists('href', $this->data) ? $this->data['href'] : null;
            $this->title = array_key_exists('title', $this->data) ? $this->data['title'] : null;
            $this->description = array_key_exists('description', $this->data) ? $this->data['description'] : null;
            $this->external = array_key_exists('external', $this->data) ? $this->data['external'] : false;
            $this->icon = array_key_exists('icon', $this->data) ? $this->data['icon'] : null;
        }

        return view('components.link');
    }
}
