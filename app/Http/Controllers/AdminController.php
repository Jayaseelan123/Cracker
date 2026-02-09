<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login() {
        return view('admin.login');
    }

    public function loginPost(Request $request) {
        return redirect()->route('admin.dashboard');
    }

    public function dashboard() {
        return view('admin.dashboard');
    }
}
