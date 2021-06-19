<?php

namespace App\Http\Controllers\Api\Wiki;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class WikiController extends Controller
{
	public function index(Request $request)
	{
		$composer = file_get_contents(base_path('composer.json'));
		$composer = json_decode($composer);

		// $php = $composer->{'require'}->php;
		// $laravel = $composer->{'require'}->{'laravel/framework'};

		$laravelVersion = Application::VERSION;
		$phpVersion = PHP_VERSION;

		return view('pages.api.wiki.index', compact('laravelVersion', 'phpVersion'));
	}
}
