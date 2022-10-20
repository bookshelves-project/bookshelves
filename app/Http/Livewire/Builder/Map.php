<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;

class Map extends Component
{
    public float $lat = 0;
    public float $lng = 0;
    public string $url = '';

    public function mount()
    {
        $this->url = "https://maps.google.com/maps?q={$this->lat},{$this->lng}&t=&z=15&ie=UTF8&iwloc=&output=embed";
    }

    public function render()
    {
        return view('livewire.builder.map');
    }
}
