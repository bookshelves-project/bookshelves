<?php

namespace App\Http\Livewire\Social;

use Kiwilan\Steward\Services\OpenGraphService;
use Livewire\Component;

class OpenGraph extends Component
{
    public ?string $url = null;
    public bool $margin = true;
    public bool $sync = false;

    public bool $loaded = false;

    public ?string $title = null;
    public ?string $description = null;
    public ?string $image = null;
    public ?string $site_url = null;
    public ?string $type = null;
    public ?string $site_name = null;
    public ?string $locale = null;
    public ?string $theme_color = null;

    public function fetchData()
    {
        if ($this->url) {
            $og = OpenGraphService::make($this->url);

            $this->title = $og->title;
            $this->description = $og->description;
            $this->image = $og->image;
            $this->site_url = $og->site_url;
            $this->type = $og->type;
            $this->site_name = $og->site_name;
            $this->locale = $og->locale;
            $this->theme_color = $og->theme_color;

            $this->loaded = true;
        }
    }

    public function render()
    {
        if ($this->sync) {
            $this->fetchData();
        }

        return view('livewire.social.open-graph');
    }
}
