<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $current_year = date('Y');
        $begin_year = 2020;
        $date = "{$begin_year} - {$current_year}";
        if ($begin_year == $current_year) {
            $date = $begin_year;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')));

        return view('components.layouts.footer', compact('composer', 'date'));
    }
}
