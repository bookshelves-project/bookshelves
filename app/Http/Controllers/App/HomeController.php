<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function index()
    {
        return inertia('Home');
    }

    #[Get('/about', name: 'about')]
    public function about()
    {
        return inertia('Home');
    }

    #[Get('/about/home', name: 'about.home')]
    public function aboutHome()
    {
        return inertia('Home');
    }

    #[Get('/about/home/{slug}', name: 'about.home.slug')]
    public function aboutHomeSlug(string $slug)
    {
        return inertia('Home');
    }

    #[Get('/about/params/{author:slug}', name: 'about.params.author')]
    public function aboutParamsAuthor(Author $author)
    {
        return inertia('Home');
    }
}
