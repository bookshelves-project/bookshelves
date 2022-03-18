<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\MarkdownService;
use Illuminate\Support\Facades\File;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'front.home')]
    public function index()
    {
        $service = MarkdownService::generate('welcome.md');
        $welcome = $service->convertToHtml();

        $service = MarkdownService::generate('developers.md');
        $developers = $service->convertToHtml();

        return view('front::pages.index', compact('welcome', 'developers'));
    }
}
