<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FeaturesController extends Controller
{
    use SEOToolsTrait;

    public function __invoke(Request $request)
    {
        // $page = Page::query()
        //     ->active()
        //     ->whereSlug(
        //         Str::of($request->path())
        //             ->replaceFirst(DomitysContext::PRO_PREFIX_PATH, '')
        //             ->ltrim('/')
        //             ->whenEmpty(fn () => '/')
        //     )
        //     ->firstOrFail()
        // ;

        // $this->seo()
        //     ->setTitle($page->meta_title ?: $page->title)
        //     ->setDescription($page->meta_description)
        // ;

        // app(Breadcrumbs::class)->add([
        //     'text' => $page->title,
        //     'href' => url($page->path),
        // ]);

        // if ($request->routeIs('home') || DomitysContext::PRO_PREFIX_PATH === $request->path()) {
        //     app(Breadcrumbs::class)->hide();
        // }

        // if ($request->routeIs('home')) {
        //     app(DataLayer::class)->push([
        //         'pageTemplate' => 'Page Accueil',
        //         'pageCategory' => 'Homepage',
        //         'pageName' => $page->title,
        //     ]);
        // } else {
        //     app(DataLayer::class)->push([
        //         'pageTemplate' => 'Page informative',
        //         'pageCategory' => 'Groupe Domitys',
        //         'pageSubCategory' => $page->title,
        //         'pageName' => $page->title,
        //     ]);
        // }

        // return view('front::page', ['page' => $page]);
        SEOTools::setTitle('Features');

        return view('features::index');
    }

    public function license()
    {
        $license = File::get(base_path('LICENSE'));
        $license = str_replace("\n", '<br>', $license);

        return view('features::pages.license', compact('license'));
    }
}
