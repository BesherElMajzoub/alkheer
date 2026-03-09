<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('is_admin')) {
            return redirect('/admin');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $adminPassword = env('ADMIN_PASSWORD', 'admin123');

        if ($request->password === $adminPassword) {
            session(['is_admin' => true]);
            return redirect('/admin');
        }

        return back()->with('error', 'كلمة المرور غير صحيحة');
    }

    public function logout()
    {
        session()->forget('is_admin');
        return redirect('/admin/login');
    }
}
