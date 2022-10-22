<?php

namespace App\Http\Livewire\Social;

use Kiwilan\Steward\Enums\SocialEnum;
use Kiwilan\Steward\Services\SocialService;
use Livewire\Component;

class Embed extends Component
{
    public string $url = '';
    public bool $googleMap = false;
    public string $latitude = '';
    public string $longitude = '';

    public bool $loaded = false;

    public string $width = '100%';
    public string $height = '450';
    public bool $rounded = false;
    public string $allow = '';
    public bool $is_mobile = false;

    public string $media_id = '';
    public string $title = '';
    public ?string $embedded = null;

    public bool $is_frame = false;
    public bool $is_open_graph = false;
    public bool $is_custom = false;

    public ?string $custom = null;

    public ?string $current_type = null;

    protected ?SocialEnum $type = null;

    public function mount()
    {
        if (preg_match('/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\\.browser|up\\.link|webos|wos)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $this->is_mobile = true;
            $this->allow .= ' accelerometer; autoplay; encrypted-media; gyroscope; clipboard-write; picture-in-picture;';
        }
    }

    public function render()
    {
        // $this->fetchData();

        return view('livewire.social.embed');
    }

    public function fetchData()
    {
        if ($this->googleMap) {
            $this->setGoogleMap();
        } else {
            $this->setSocial();
        }

        $this->loaded = true;
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
            $this->current_type = $this->type->value;
        }

        if ($social->getIsCustom()) {
            $this->is_custom = true;
            $this->custom = "social.{$this->current_type}";
            // $this->embedded = $social->getEmbedded();
        }

        if ($social->getIsUnknown()) {
            $this->is_open_graph = true;
        }

        if ($social->getIsFrame()) {
            $this->is_frame = true;
            $this->url = $social->getEmbedUrl();

            if (SocialEnum::spotify === $this->type) {
                $this->height = '200';
            }

            if (SocialEnum::twitter === $this->type) {
                $this->height = '350';
            }

            if (SocialEnum::facebook === $this->type) {
                $this->height = '591';
                $this->width = '476';
            }
        }
    }
}
