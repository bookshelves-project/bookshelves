<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\MarkdownService;
use Illuminate\Support\Facades\File;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function index()
    {
        $service = MarkdownService::generate('welcome.md');
        $welcome = $service->convertToHtml();

        $service = MarkdownService::generate('developers.md');
        $developers = $service->convertToHtml();

        return view('front::pages.index', compact('welcome', 'developers'));
    }

    #[Get('/features', name: 'front.home')]
    public function home()
    {
        return redirect()->route('home');
    }

    #[Get('/features/license', name: 'front.license')]
    public function license()
    {
        $license = File::get(base_path('LICENSE'));
        $license = str_replace("\n", '<br>', $license);

        return view('front::pages.license', compact('license'));
    }
}
