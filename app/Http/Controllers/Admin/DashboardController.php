<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return Inertia::render('Dashboard');
    }
}
