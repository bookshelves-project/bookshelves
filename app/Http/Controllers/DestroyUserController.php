<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

class DestroyUserController extends Controller
{
    public function destroy(Request $request, StatefulGuard $auth)
    {
        $request->validate([
            'password' => 'required|string|password',
        ]);

        $request->user()->fresh()->delete();

        $auth->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
