<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\ContactInquiryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CompanyDetailController;


// ----------------------------
// Public Routes
// ----------------------------
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/download-products', [FrontController::class, 'downloadProducts'])->name('download.products');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/terms', [FrontController::class, 'terms'])->name('terms');
Route::get('/privacy', [FrontController::class, 'privacy'])->name('privacy');
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

// Public Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/category/{category}', [BlogController::class, 'filterByCategory'])->name('blog.category');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');


// ----------------------------
// Admin Routes
// ----------------------------
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

// Password Reset Routes
Route::get('/admin/forgot-password', [AdminAuthController::class, 'showLinkRequestForm'])
    ->name('admin.password.request');

Route::post('/admin/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])
    ->name('admin.password.email');

Route::get('/admin/reset-password/{token}', [AdminAuthController::class, 'showResetForm'])
    ->name('admin.password.reset');

Route::post('/admin/reset-password', [AdminAuthController::class, 'resetPassword'])
    ->name('admin.password.update');

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

// Admin Profile Routes
Route::get('/admin/profile', [AdminAuthController::class, 'showProfile'])
    ->middleware('auth')
    ->name('admin.profile');

Route::post('/admin/profile/update', [AdminAuthController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('admin.profile.update');

// Admin category resource routes (CRUD)
Route::resource('category', CategoryController::class)->middleware('auth');

// Admin products resource
Route::resource('products', ProductController::class)->middleware('auth');
Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->middleware('auth')->name('products.toggleStatus');

// Admin banners resource
Route::resource('banners', \App\Http\Controllers\BannerController::class)->middleware('auth');
Route::post('/banners/{banner}/toggle-status', [\App\Http\Controllers\BannerController::class, 'toggleStatus'])->middleware('auth')->name('banners.toggleStatus');

// Admin orders
Route::get('/admin/orders', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::get('/admin/direct-enquiry', [AdminEnquiryController::class, 'directEnquiry'])->middleware('auth')->name('admin.direct.enquiry');
Route::post('/admin/direct-enquiry', [AdminEnquiryController::class, 'storeDirect'])->middleware('auth')->name('admin.direct.enquiry.store');
Route::get('/admin/enquiry-customer', [AdminEnquiryController::class, 'enquiryCustomer'])->middleware('auth')->name('admin.enquiry.customer');
Route::get('/admin/enquiry-customer/export', [AdminEnquiryController::class, 'exportCustomer'])->middleware('auth')->name('admin.enquiry.customer.export');
Route::post('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->middleware('auth')->name('orders.status');
// Delete order/enquiry
Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->middleware('auth')->name('admin.orders.destroy');
// View order details
Route::get('/admin/orders/view/{id}', [OrderController::class, 'view'])->middleware('auth')->name('admin.orders.view');
// Download order PDF
Route::get('/admin/orders/pdf/{id}', [OrderController::class, 'downloadPdf'])->middleware('auth')->name('admin.orders.pdf');

// Admin Blog CRUD routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('blogs', \App\Http\Controllers\Admin\AdminBlogController::class);
});

// Admin Contact Inquiries
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('contact-inquiries', [ContactInquiryController::class, 'index'])->name('contact-inquiries.index');
    Route::get('contact-inquiries/{contactInquiry}', [ContactInquiryController::class, 'show'])->name('contact-inquiries.show');
    Route::post('contact-inquiries/{contactInquiry}/reply', [ContactInquiryController::class, 'storeReply'])->name('contact-inquiries.reply');
    Route::post('contact-inquiries/{contactInquiry}/replied', [ContactInquiryController::class, 'markReplied'])->name('contact-inquiries.replied');
    Route::delete('contact-inquiries/{contactInquiry}', [ContactInquiryController::class, 'destroy'])->name('contact-inquiries.destroy');
});

// Admin Company Settings (single-record)
Route::middleware('auth')->group(function () {
    Route::get('/admin/company', [CompanyDetailController::class, 'edit'])->name('admin.company.edit');
    Route::put('/admin/company', [CompanyDetailController::class, 'update'])->name('admin.company.update');
});

// Admin Site Settings + Delivery Zones + Terms Sections
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\DeliveryZoneController;
use App\Http\Controllers\TermsSectionController;

Route::middleware('auth')->group(function () {
    // General Settings
    Route::get('/admin/settings', [SiteSettingController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');
    Route::post('/admin/settings/save-combined', [SiteSettingController::class, 'saveCombined'])->name('admin.settings.combined');

    // Delivery Zones
    Route::post('/admin/delivery-zones', [DeliveryZoneController::class, 'store'])->name('admin.delivery.store');
    Route::put('/admin/delivery-zones/{deliveryZone}', [DeliveryZoneController::class, 'update'])->name('admin.delivery.update');
    Route::delete('/admin/delivery-zones/{deliveryZone}', [DeliveryZoneController::class, 'destroy'])->name('admin.delivery.destroy');
    Route::post('/admin/delivery-zones/reorder', [DeliveryZoneController::class, 'reorder'])->name('admin.delivery.reorder');
    Route::post('/admin/delivery-zones/{deliveryZone}/toggle', [DeliveryZoneController::class, 'toggle'])->name('admin.delivery.toggle');

    // Terms & Privacy Sections
    Route::post('/admin/terms-sections', [TermsSectionController::class, 'store'])->name('admin.terms.store');
    Route::put('/admin/terms-sections/{termsSection}', [TermsSectionController::class, 'update'])->name('admin.terms.update');
    Route::delete('/admin/terms-sections/{termsSection}', [TermsSectionController::class, 'destroy'])->name('admin.terms.destroy');
    Route::post('/admin/terms-sections/reorder', [TermsSectionController::class, 'reorder'])->name('admin.terms.reorder');
});

// Public API: settings JSON for frontend JS
Route::get('/api/settings', function () {
    $settings = \App\Models\SiteSetting::getAllCached();
    $allowed = [
        'show_pricelist_home', 'show_pricelist_download',
        'show_product_code', 'show_discount_row',
        'enable_category_filter', 'enable_search_filter',
        'pdf_font_size', 'website_status', 'new_arrival_days', 'price_format',
    ];
    return response()->json(array_intersect_key($settings, array_flip($allowed)));
})->name('api.settings');
