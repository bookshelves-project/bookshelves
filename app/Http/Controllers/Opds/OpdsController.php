<?php

namespace App\Http\Controllers\Opds;

use File;
use Route;
use App\Enums\EntitiesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\CommonMarkProvider;
use App\Providers\Bookshelves\OpdsProvider;

/**
 * @hideFromAPIDocumentation
 */
class OpdsController extends Controller
{
    public function index(Request $request)
    {
        $markdown = CommonMarkProvider::generate("opds/content/index.md");
        $content = $markdown->content;
        $date = $markdown->date;
        
        return view('pages.opds.index', compact('content'));
    }

    public function feed(Request $request, string $version)
    {
        $feed = File::get(app_path('Providers/Bookshelves/Feed/opds.json'));
        $feed = (array) json_decode($feed);
        foreach ($feed as $key => $value) {
            $model_name = 'App\Models\\'.ucfirst($value->model);
            $value->cover_thumbnail = config('app.url').'/storage/assets/'.$value->key.'.png';
            $value->route = route($value->route, ['version' => $version]);
            $value->content = $model_name::count().' '.$value->content;
        }
        $feed = collect($feed);

        $current_route = route(Route::currentRouteName(), ['version' => $version]);
        $opdsProvider = new OpdsProvider(
            version: $version,
            entity: EntitiesEnum::FEED(),
            route: $current_route,
            data: $feed,
        );
        $result = $opdsProvider->template();

        return response($result)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }
}
