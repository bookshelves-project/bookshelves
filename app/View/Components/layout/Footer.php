<?php

namespace App\View\Components\layout;

use Illuminate\View\Component;
use Illuminate\Foundation\Application;

class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $currentYear = date('Y');
        $beginYear = 2020;
        $date = "$beginYear - $currentYear";
        if ($beginYear === $currentYear) {
            $date = $beginYear;
        }

        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;
        $composer = json_decode(file_get_contents(base_path('composer.json')));

        return view('components.layout.footer', compact('laravelVersion', 'phpVersion', 'composer', 'date'));
    }
}
