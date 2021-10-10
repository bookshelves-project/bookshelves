<?php

namespace App\Http\Controllers\Roadmap;

use App\Http\Controllers\Controller;
use App\Providers\CommonMarkProvider;

class RoadmapController extends Controller
{
    public function index()
    {
        $markdown = CommonMarkProvider::generate('roadmap/content/index.md');
        $content = $markdown->content;
        $date = $markdown->date;

        return view('pages.features.roadmap.index', compact('content', 'date'));
    }
}
