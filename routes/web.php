<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


// ----------------------------
// Public Routes
// ----------------------------
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::post('/contact/send', [App\Http\Controllers\FrontController::class, 'contactSubmit'])->name('contact.send');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/order-success/{order}', [CheckoutController::class, 'success'])->name('order.success');
// Dev helper: seed session cart with first product to preview checkout quickly (REMOVE in production)
Route::get('/dev/seed-cart', function () {
    $product = App\Models\Product::first();
    if (!$product) {
        return redirect()->back()->with('error', 'No products found to seed cart.');
    }
    session(['cart' => [$product->id => 1]]);
    return redirect()->route('checkout');
});
Route::get('/cart', [CartController::class, 'index'])->name('cart.view');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// AJAX cart endpoints for drawer updates (no page reload)
Route::post('/cart/ajax/add/{id}', [CartController::class, 'ajaxAdd'])->name('cart.ajax.add');
Route::post('/cart/ajax/decrease/{id}', [CartController::class, 'ajaxDecrease'])->name('cart.ajax.decrease');
Route::post('/cart/ajax/update/{id}', [CartController::class, 'ajaxUpdate'])->name('cart.ajax.update');
Route::post('/cart/ajax/remove/{id}', [CartController::class, 'ajaxRemove'])->name('cart.ajax.remove');
Route::get('/cart/view/partial', function () {
    $cart = session('cart', []);
    return view('front.partials.drawer', compact('cart'))->render();
})->name('cart.view.partial');

// Public content pages
Route::get('/blog', [App\Http\Controllers\FrontController::class, 'blog'])->name('blog');


// ----------------------------
// Admin Routes
// ----------------------------
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

// Logout (using GET for compatibility with existing links)
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard.legacy');

// Primary admin dashboard
Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');

// Admin category resource routes (CRUD)
Route::resource('category', CategoryController::class)->middleware('auth');

// Admin products resource
Route::resource('products', ProductController::class)->middleware('auth');

// Admin orders
Route::get('/admin/orders', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::post('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->middleware('auth')->name('orders.status');
// View order details
Route::get('/admin/orders/view/{id}', [OrderController::class, 'view'])->middleware('auth')->name('admin.orders.view');
// Download order PDF
Route::get('/admin/orders/pdf/{id}', [OrderController::class, 'downloadPdf'])->middleware('auth')->name('admin.orders.pdf');

