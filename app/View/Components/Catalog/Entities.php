<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class Entities extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public AnonymousResourceCollection $collection,
        public ?string $type = 'book',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $entities = json_decode(json_encode($this->collection->toJson()), true);
        $entities = json_decode($entities);

        return view('components.catalog.entities', compact('entities'));
    }
}
