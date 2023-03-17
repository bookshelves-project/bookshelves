<?php

namespace App\Http\Controllers\Opds;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('/')]
class IndexController extends Controller
{
    #[Get('/', name: 'index')]
    public function index(Request $request)
    {
        $versions = [
            route('opds.version', ['version' => '1.2']),
        ];

        return redirect($versions[count($versions) - 1]);
    }

    #[Get('/{version}', name: 'version')]
    public function version(Request $request)
    {
        $engine = OpdsEngine::create($request);

        return $engine->index();
    }

    #[Get('/{version}/search', name: 'search')]
    public function search(Request $request)
    {
        $engine = OpdsEngine::create($request);

        return $engine->search();
    }
}
