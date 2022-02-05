<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function redirect()
    {
        return redirect()->route('admin.dashboard');
    }

    public function index()
    {
        $data = [
            'chart' => [
                'labels' => [
                    'Books',
                    'Series',
                    'Authors',
                    'Tags',
                    'Publishers',
                    'Languages',
                ],
                'values' => [
                    Book::count(),
                    Serie::count(),
                    Author::count(),
                    TagExtend::count(),
                    Publisher::count(),
                    Language::count(),
                ],
                'colors' => [
                    '#a7a1ff',
                    '#8982ff',
                    '#6c63ff',
                    '#564fcc',
                    '#413b99',
                    '#2b2866',
                ],
            ],
        ];

        return Inertia::render('Dashboard', $data);
    }
}
