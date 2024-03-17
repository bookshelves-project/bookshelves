<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function index()
    {
        return inertia('Welcome');
    }

    #[Get('/about', name: 'about')]
    public function about()
    {
        return inertia('About');
    }
}
