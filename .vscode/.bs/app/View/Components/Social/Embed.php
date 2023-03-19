<?php

namespace App\View\Components\Social;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Kiwilan\Steward\Enums\SocialEnum;
use Kiwilan\Steward\Services\IframelyService;

class Embed extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $url,
        public ?string $key = null,
        public ?string $type = null,
        public ?string $html = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $type = SocialEnum::find($this->url);
        $this->type = $type?->value;
        $this->key = Str::random();

        // $iframely = IframelyService::make();
        // $data = $iframely->get($this->url);

        // $this->html = $data['html'] ?? '';

        return view('components.social.embed');
    }
}
