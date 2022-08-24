<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Utils\FrontNavigation;
use Artesaos\SEOTools\Facades\SEOTools;
use Intervention\Image\Gd\Font;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

class FrontController extends Controller
{
    #[Get('/', name: 'index')]
    public function index()
    {
        $developer = FrontNavigation::getDeveloperNavigation();

        return view('front::pages.index', compact('developer'));
    }

    #[Get('/features/catalog', name: 'catalog')]
    public function catalog()
    {
        SEOTools::setTitle('Use Catalog');

        return view('front::pages.catalog');
    }

    #[Get('/features/opds', name: 'opds')]
    public function opds()
    {
        SEOTools::setTitle('Use OPDS feed');
        $feeds = [
            [
                'label' => 'Version 1.2',
                'route' => route('front.opds'),
            ],
        ];

        return view('front::pages.opds', compact('feeds'));
    }

    #[Get('/features/webreader', name: 'webreader')]
    public function webreader()
    {
        SEOTools::setTitle('Use Webreader');

        return view('front::pages.webreader');
    }
}
