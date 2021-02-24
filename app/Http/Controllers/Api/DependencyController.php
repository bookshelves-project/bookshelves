<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DependencyController extends Controller
{
    public function index()
    {
        $composerJson = file_get_contents(base_path('composer.json'));
        $composerJson = json_decode($composerJson);

        return response()->json($composerJson);
    }

    public function show(string $slashData)
    {
        $composerJson = file_get_contents(base_path('composer.json'));
        $composerJson = str_replace('/', '-', $composerJson);
        $composerJson = json_decode($composerJson);
        // dd($composerJson);
        if ($slashData) {
            // dump($slashData);
            $slashDataParameters = explode('/', $slashData);
            // dump($slashDataParameters);
            // dump($composerJson->reqire->{'laravel/framework'});
            $finalRequest = null;
            foreach ($slashDataParameters as $key => $parameter) {
                // $isLastElement = sizeof($slashDataParameters) - 1;
                // $addArrow = $isLastElement <= $key ? '' : '->';
                // $finalRequest .= $parameter.$addArrow;
                // dump($composerJson->$parameter);
            }
            // dump($composerJson->);
            // dump($composerJson->$slashDataParameters);
        }

        // return response()->json($composerJson->$base->$second);
    }
}
