<?php

namespace App\Http\Livewire\Social;

use Livewire\Component;

class Instagram extends Component
{
    public bool $basic = false;

    public string $url = '';

    public function render()
    {
        return view('livewire.social.instagram');
    }
}
