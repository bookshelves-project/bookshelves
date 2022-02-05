<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\MarkdownService;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $service = MarkdownService::generate('welcome.md');
        $welcome = $service->convertToHtml();

        $service = MarkdownService::generate('developers.md');
        $developers = $service->convertToHtml();

        return view('front::pages.index', compact('welcome', 'developers'));
    }

    public function license()
    {
        $license = File::get(base_path('LICENSE'));
        $license = str_replace("\n", '<br>', $license);

        return view('front::pages.license', compact('license'));
    }
}
