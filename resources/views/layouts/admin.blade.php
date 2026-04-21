<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { height: 100vh; background: white; border-right: 1px solid #ddd; position: fixed; width: 250px; }
        .sidebar a { display: block; padding: 15px; color: #333; text-decoration: none; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background: #6f42c1; color: white; }
        .main-content { margin-left: 250px; padding: 20px; background: #f4f6f9; min-height: 100vh; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; align-items: center; }
        .icon-box { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 1.5rem; }
    </style>
    @stack('head')
</head>
<body>

<div class="sidebar">
    <div class="p-3 text-center fw-bold text-purple border-bottom">
        <i class="fas fa-fire"></i> CRACKERS ADMIN
    </div>
    <a href="{{ Route::has('category.index') ? route('category.index') : '#' }}" class="{{ request()->routeIs('category.*') ? 'active' : '' }}"><i class="fas fa-list me-2"></i> Categories</a>
    <li class="nav-item">
        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <img src="{{ asset('images/icons/product.png') }}" alt="Products" width="22" height="22" class="me-2 align-middle" onerror="this.style.display='none'">
            <i class="fas fa-box me-2" aria-hidden="true"></i>
            Products
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
            <i class="fa fa-shopping-cart me-2"></i>
            Orders
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.direct.enquiry') }}" class="nav-link {{ request()->routeIs('admin.direct.enquiry') ? 'active' : '' }}">
            <i class="fas fa-paper-plane me-2"></i>
            Direct Enquiry
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.enquiry.customer') }}" class="nav-link {{ request()->routeIs('admin.enquiry.customer') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i>
            Enquiry Customer
        </a>
    </li>
    <a href="{{ url('/') }}" class="mt-5 border-top"><i class="fas fa-sign-out-alt me-2"></i> Visit Website</a>
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">@yield('header', 'Dashboard')</span>
            <div class="d-flex align-items-center">
                <span class="me-3">{{ auth()->user()?->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
