<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Kiwilan\Steward\Services\OpenGraphService;
use Kiwilan\Steward\Services\OpenGraphService\OpenGraphItem;

class OpenGraph extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?OpenGraphItem $og = null,
        public ?string $url = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->url) {
            // TODO twitter
            $this->og = OpenGraphService::make($this->url);
        }

        return view('components.open-graph');
    }
}
