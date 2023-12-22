<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Utils\FrontNavigation;
use Spatie\RouteAttributes\Attributes\Get;

class BookController extends Controller
{
    #[Get('/books', name: 'front.books.index')]
    public function index()
    {
        // $developer = FrontNavigation::getDeveloperNavigation();

        return inertia('Books/Index', [
            // 'developer' => $developer,
        ]);
    }
}
