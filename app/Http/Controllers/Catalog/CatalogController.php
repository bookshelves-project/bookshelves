<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('catalog')]
class CatalogController extends Controller
{
    #[Get('/', name: 'index')]
    public function index()
    {
        return view('catalog::pages.index');
    }
}
