<?php

namespace App\Http\Controllers\Features\Roadmap;

use App\Http\Controllers\Controller;
use App\Services\CommonMarkService;

class RoadmapController extends Controller
{
    public function index()
    {
        $markdown = CommonMarkService::generate('roadmap/content/index.md');
        $content = $markdown->content;
        $date = $markdown->date;

        return view('pages.features.roadmap.index', compact('content', 'date'));
    }
}
