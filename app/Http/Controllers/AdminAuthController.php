<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check admin user only
        $credentials = $request->only('email', 'password') + ['is_admin' => 1];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['error' => 'Invalid admin credentials']);
    }

    public function dashboard()
    {
        // gather basic stats for the dashboard
        $totalUsers = \App\Models\User::count();
        $totalCategories = \App\Models\Category::count();
        $totalProducts = \App\Models\Product::count();
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();

        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers','totalCategories','totalProducts','totalOrders','pendingOrders','recentOrders'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
