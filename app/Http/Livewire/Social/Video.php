<?php

namespace App\Http\Livewire\Social;

use Livewire\Component;

class Video extends Component
{
    public string $url = '';
    public string $title = 'Vimeo video player';

    public function render()
    {
        // https://www.dailymotion.com/video/x8elgz7 => https://www.dailymotion.com/embed/video/x8elgz7
        // https://www.youtube.com/watch?v=0c9aRUTSV6U => https://www.youtube.com/embed/0c9aRUTSV6U
        // https://vimeo.com/161110645 => https://player.vimeo.com/video/161110645?h=e46badf906

        return view('livewire.social.video');
    }
}
