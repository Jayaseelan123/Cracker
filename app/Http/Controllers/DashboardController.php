<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $totalProducts = Product::count();
        $categories = Category::count();
        $recentOrders = Order::orderBy('id', 'DESC')->limit(5)->get();

        return view('admin.dashboard.index', compact(
            'totalOrders', 'pendingOrders', 'totalProducts', 'categories', 'recentOrders'
        ));
    }
}
