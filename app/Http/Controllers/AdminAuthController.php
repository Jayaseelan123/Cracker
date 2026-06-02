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
            'email' => 'required',
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

    public function showLinkRequestForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = \App\Models\User::where('email', $request->email)->where('is_admin', 1)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find an admin user with that email address.']);
        }

        $token = \Illuminate\Support\Facades\Password::getRepository()->create($user);

        // Send customized admin reset email
        $user->notify(new \App\Notifications\AdminResetPasswordNotification($token));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('admin.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = \App\Models\User::where('email', $request->email)->where('is_admin', 1)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find an admin user with that email address.']);
        }

        if (!\Illuminate\Support\Facades\Password::getRepository()->exists($user, $request->token)) {
            return back()->withErrors(['email' => 'This password reset token is invalid.']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        \Illuminate\Support\Facades\Password::getRepository()->delete($user);

        return redirect()->route('admin.login')->with('status', 'Your password has been reset!');
    }

    public function showProfile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
        ];

        // If old password is provided, validate new password too
        if ($request->filled('old_password')) {
            $rules['old_password'] = 'required';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        // Verify old password if they want to change it
        if ($request->filled('old_password')) {
            if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'The provided current password does not match our records.']);
            }
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('status', 'Profile updated successfully!');
    }
}
