<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function index()
    {
        return view('front::app');
    }
}
