<?php

namespace App\Http\Livewire\Social;

use Kiwilan\Steward\Services\OpenGraphService\OpenGraphTwitter;
use Livewire\Component;

class Twitter extends Component
{
    public string $url;
    public string $html = '';

    public function render()
    {
        $twitter = OpenGraphTwitter::make($this->url);
        // $this->html = $twitter->getHtml();

        return view('livewire.social.twitter');
    }
}
