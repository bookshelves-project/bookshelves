<?php

namespace App\Http\Livewire;

use Kiwilan\Steward\Enums\BuilderEnum\SocialEnum;
use Livewire\Component;

class Social extends Component
{
    public string $width = '100%';
    public string $height = '500';
    public bool $rounded = false;
    public string $url = '';
    public string $video_id = '';
    public ?SocialEnum $origin = null;
    public string $title = '';

    public function render()
    {
        return view('livewire.social');
    }
}
