<?php

namespace App\Http\Livewire\Social;

use Kiwilan\Steward\Services\OpenGraphService;
use Kiwilan\Steward\Services\OpenGraphService\OpenGraphItem;
use Livewire\Component;

class OpenGraph extends Component
{
    public mixed $og = null;
    public ?string $url = null;
    public bool $margin = true;

    protected ?OpenGraphItem $openGraph = null;

    public function render()
    {
        if ($this->url && ! $this->og) {
            $this->og = OpenGraphService::make($this->url);
        }

        return view('livewire.social.open-graph');
    }
}
