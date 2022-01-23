<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function redirect()
    {
        return redirect()->route('admin.dashboard');
    }

    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
