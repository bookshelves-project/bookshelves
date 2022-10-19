<?php

namespace App\Http\Livewire\Social;

use Http;
use Livewire\Component;

class Twitter extends Component
{
    public bool $loading = true;
    public string $url = '';
    public string $embedded = '';

    public function mount()
    {
        // https://developer.twitter.com/en/docs/twitter-for-websites/embedded-tweets/overview
        // https://twitter.com/la_briochee_off/status/1581733181551955968
        $api = 'https://publish.twitter.com/oembed?url=';
        $client = Http::get("{$api}{$this->url}");
        $body = $client->json();

        $this->embedded = $body['html'];
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.social.twitter');
    }
}
