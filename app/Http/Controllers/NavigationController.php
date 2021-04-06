<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;

class NavigationController extends Controller
{
    public function welcome()
    {
        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;

        return view('pages/welcome', compact('laravelVersion', 'phpVersion'));
    }

    public function ereader()
    {
        return view('pages/api/ereader');
    }

    public function documentation()
    {
        return view('pages/api/documentation');
    }
}
