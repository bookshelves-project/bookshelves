<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;

class NavigationController extends Controller
{
    public function welcome()
    {
        $laravelVersion = Application::VERSION;
        $phpVersion = PHP_VERSION;

        return view('welcome', compact('laravelVersion', 'phpVersion'));
    }
}
