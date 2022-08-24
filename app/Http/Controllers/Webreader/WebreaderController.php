<?php

namespace App\Http\Controllers\Webreader;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('webreader')]
class WebreaderController extends Controller
{
    #[Get('/', name: 'index')]
    public function index()
    {
        return view('webreader::pages.index');
    }
}
