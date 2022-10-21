<?php

namespace App\Http\Livewire;

use Kiwilan\Steward\Enums\SocialEnum;
use Kiwilan\Steward\Services\OpenGraphService\OpenGraphItem;
use Kiwilan\Steward\Services\SocialService;
use Livewire\Component;

class Embed extends Component
{
    public string $url = '';
    public bool $googleMap = false;
    public string $latitude = '';
    public string $longitude = '';

    public string $width = '100%';
    public string $height = '450';
    public bool $rounded = false;
    public string $allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';

    public string $media_id = '';
    public string $title = '';
    public ?string $embedded = null;

    public bool $is_frame = false;
    public bool $is_open_graph = false;
    public bool $is_embedded = false;

    protected ?SocialEnum $type = null;
    protected ?OpenGraphItem $openGraph = null;

    public function getOpenGraph()
    {
        return $this->openGraph;
    }

    public function render()
    {
        return view('livewire.social.embed');
    }

    public function fetch()
    {
        if ($this->googleMap) {
            $this->setGoogleMap();
        } else {
            $this->setSocial();
        }
    }

    private function setGoogleMap()
    {
        $url = "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}";
        $url .= '&t=';
        $url .= '&z=15';
        $url .= '&ie=UTF8';
        $url .= '&iwloc=';
        $url .= '&output=embed';

        $this->url = $url;
        $this->is_frame = true;
    }

    private function setSocial()
    {
        $this->type = SocialEnum::find($this->url);
        $social = SocialService::make($this->url);

        if ($this->type) {
            $this->title = $this->type->locale();
        }

        if ($social->getIsEmbedded()) {
            $this->is_embedded = true;
            $this->embedded = $social->getEmbedded();
        }

        if ($social->getIsUnknown()) {
            $this->is_open_graph = true;
            $this->openGraph = $social->getOpenGraph();
        }

        if ($social->getIsFrame()) {
            $this->is_frame = true;
            $this->url = $social->getEmbedUrl();

            if (SocialEnum::spotify === $this->type) {
                $this->height = '200';
            }
        }
    }
}
