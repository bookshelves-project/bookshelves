<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

class FrontController extends Controller
{
    #[Get('/', name: 'index')]
    public function index()
    {
        return view('front::pages.index');
    }
}
