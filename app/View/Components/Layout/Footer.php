<?php

namespace App\View\Components\Layout;

use Illuminate\Foundation\Application;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $currentYear = date('Y');
        $beginYear = 2020;
        $date = "{$beginYear} - {$currentYear}";
        if ($beginYear === $currentYear) {
            $date = $beginYear;
        }

        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;
        $composer = json_decode(file_get_contents(base_path('composer.json')));

        return view('components.layout.footer', compact('laravelVersion', 'phpVersion', 'composer', 'date'));
    }
}
