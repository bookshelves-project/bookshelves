<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\TagExtend;
use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;

class DashboardController extends Controller
{
    #[Get('/')]
    public function redirect()
    {
        return redirect()->route('admin.dashboard');
    }

    #[Get('dashboard', name: 'dashboard')]
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
            ],
        ];

        return Inertia::render('Dashboard', $data);
    }
}
