<?php

namespace App\Http\Livewire\Social;

use Kiwilan\Steward\Enums\SocialEnum;
use Kiwilan\Steward\Services\IframelyService;
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

    public ?string $html = null;

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
        $query = http_build_query([
            't' => '',
            'z' => 15,
            'ie' => 'UTF8',
            'iwloc' => '',
            'output' => 'embed',
        ]);
        $url = "{$url}?{$query}";

        $this->url = $url;
        $this->is_frame = true;
    }

    private function setSocial()
    {
        // $this->type = SocialEnum::find($this->url);
        // $social = SocialService::make($this->url);
        $iframely = IframelyService::make();
        $data = $iframely->get($this->url);
        // dump($data);

        // if ($type = $social->getType()) {
        //     $this->current_type = $type->value;
        // }

        // $this->html = $social->module->getHtml();
        $this->html = $data['html'] ?? '';

        // dump($social);
        // dd($this);

        // if ($social->getIsCustom()) {
        //     $this->is_custom = true;
        //     $this->custom = "social.{$this->current_type}";
        //     // $this->embedded = $social->getEmbedded();
        // }

        // if ($social->getIsUnknown()) {
        //     $this->is_open_graph = true;
        // }

        // if ($social->getIsFrame()) {
        //     $this->is_frame = true;
        //     $this->url = $social->getEmbedUrl();

        //     if (SocialEnum::spotify === $this->type) {
        //         $this->height = '200';
        //     }

        //     if (SocialEnum::twitter === $this->type) {
        //         $this->height = '350';
        //     }

        //     if (SocialEnum::facebook === $this->type) {
        //         $this->height = '591';
        //         $this->width = '476';
        //     }
        // }
    }
}
