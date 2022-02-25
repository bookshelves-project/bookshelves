<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use App\Models\User;
use Inertia\Inertia;
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
            'chartEntities' => [
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
            'chartUsers' => [
                'labels' => [
                    'Super admins',
                    'Admins',
                    'Publishers',
                    'Users',
                ],
                'values' => [
                    User::whereRole(RoleEnum::super_admin)->count(),
                    User::whereRole(RoleEnum::admin)->count(),
                    User::whereRole(RoleEnum::publisher)->count(),
                    User::whereRole(RoleEnum::user)->count(),
                ],
            ],
        ];

        return Inertia::render('Dashboard', $data);
    }
}
