<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        return view('front::pages.index');
    }

    public function license()
    {
        $license = File::get(base_path('LICENSE'));
        $license = str_replace("\n", '<br>', $license);

        return view('front::pages.license', compact('license'));
    }
}
