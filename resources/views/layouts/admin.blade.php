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
        .sidebar {
            height: 100vh;
            background: white;
            border-right: 1px solid #ddd;
            position: fixed;
            width: 250px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .sidebar a {
            display: block;
            padding: 13px 15px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #6f42c1;
            color: white;
        }

        .sidebar .sidebar-footer a {
            display: block;
            padding: 15px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            border-top: 1px solid #eee;
        }

        .sidebar .sidebar-footer a:hover {
            background: #6f42c1;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            background: #f4f6f9;
            min-height: 100vh;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
        }

        #sidebarSearch:focus {
            border-color: #6f42c1 !important;
            background: #fff !important;
            box-shadow: 0 0 0 2px rgba(111, 66, 193, 0.15);
        }
    </style>
    @stack('head')
</head>

<body>

    <div class="sidebar">
        {{-- Header --}}
        <div class="p-3 text-center fw-bold text-purple border-bottom flex-shrink-0">
            <i class="fas fa-fire"></i> CRACKERS ADMIN
        </div>

        {{-- Search Bar --}}
        <div class="px-3 pt-3 pb-2 flex-shrink-0">
            <div style="position:relative;">
                <i class="fas fa-search"
                    style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:13px;"></i>
                <input type="text" id="sidebarSearch" placeholder="Search"
                    style="width:100%;padding:7px 10px 7px 32px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;background:#f8f9fa;color:#333;transition:all 0.2s;"
                    oninput="filterSidebarMenu(this.value)">
            </div>
        </div>

        {{-- Scrollable Nav --}}
        <ul class="sidebar-nav" id="sidebarNav">
            <li class="nav-item" data-menu="dashboard">
                <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item" data-menu="categories">
                <a href="{{ Route::has('category.index') ? route('category.index') : '#' }}"
                    class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                    <i class="fas fa-list me-2"></i> Categories
                </a>
            </li>
            <li class="nav-item" data-menu="banners">
                <a href="{{ route('banners.index') }}"
                    class="nav-link {{ request()->routeIs('banners.*') ? 'active' : '' }}">
                    <i class="fas fa-images me-2"></i> Banners
                </a>
            </li>
            <li class="nav-item" data-menu="products">
                <a href="{{ route('products.index') }}"
                    class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-box me-2"></i> Products
                </a>
            </li>
            <li class="nav-item" data-menu="online orders">
                <a href="{{ route('orders.index') }}"
                    class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    <i class="fa fa-shopping-cart me-2"></i> Online Orders
                </a>
            </li>
            <li class="nav-item" data-menu="direct enquiry">
                <a href="{{ route('admin.direct.enquiry') }}"
                    class="nav-link {{ request()->routeIs('admin.direct.enquiry') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane me-2"></i> Direct Enquiry
                </a>
            </li>
            <li class="nav-item" data-menu="enquiry customer">
                <a href="{{ route('admin.enquiry.customer') }}"
                    class="nav-link {{ request()->routeIs('admin.enquiry.customer') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Enquiry Customer
                </a>
            </li>
            <li class="nav-item" data-menu="blog posts">
                <a href="{{ route('admin.blogs.index') }}"
                    class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-blog me-2"></i> Blog Posts
                </a>
            </li>
            <li class="nav-item" data-menu="contact inquiries" style="position:relative;">
                <a href="{{ route('admin.contact-inquiries.index') }}"
                    class="nav-link {{ request()->routeIs('admin.contact-inquiries.*') ? 'active' : '' }}"
                    style="display:flex;align-items:center;justify-content:space-between;">
                    <span><i class="fas fa-envelope me-2"></i> Contact Inquiries</span>
                    @php $unread = \App\Models\ContactInquiry::where('status', 'unread')->count(); @endphp
                    @if($unread > 0)
                        <span class="badge bg-danger rounded-pill" style="font-size:10px;">{{ $unread }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item" data-menu="company settings">
                <a href="{{ route('admin.company.edit') }}"
                    class="nav-link {{ request()->routeIs('admin.company.*') ? 'active' : '' }}">
                    <i class="fas fa-building me-2"></i> Company Settings
                </a>
            </li>
            <li class="nav-item" data-menu="site settings">
                <a href="{{ route('admin.settings') }}"
                    class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cogs me-2"></i> Site Settings
                </a>
            </li>
        </ul>

        {{-- Footer --}}
        <div class="sidebar-footer flex-shrink-0">
            <a href="{{ url('/') }}"><i class="fas fa-sign-out-alt me-2"></i> Visit Website</a>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('header', 'Dashboard')</span>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                        role="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm"
                            style="width: 38px; height: 38px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <span class="fw-medium text-dark">{{ auth()->user()?->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2"
                        aria-labelledby="adminDropdown">
                        <li>
                            <div class="px-3 py-2">
                                <span class="d-block fw-bold">{{ auth()->user()?->name ?? 'Admin' }}</span>
                                <span class="d-block small text-muted">{{ auth()->user()?->email ?? 'admin@example.com'
                                    }}</span>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.profile') }}">
                                <i class="fas fa-user-cog me-2 text-muted"></i> Profile Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ url('/') }}">
                                <i class="fas fa-external-link-alt me-2 text-muted"></i> Visit Website
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger fw-medium">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function (event) {
            if (event.target.closest('.delete-btn') || (event.target.tagName === 'BUTTON' && event.target.innerText.trim().toLowerCase() === 'delete')) {
                const button = event.target.closest('button');
                const form = button ? button.closest('form') : null;

                if (form && (form.querySelector('input[name="_method"][value="DELETE"]') || form.method.toLowerCase() === 'post')) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        background: '#fff',
                        borderRadius: '15px',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const tr = form.closest('tr');
                            if (tr) {
                                fetch(form.action, {
                                    method: 'POST',
                                    body: new FormData(form),
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                }).then(response => {
                                    tr.style.transition = 'all 0.4s ease';
                                    tr.style.opacity = '0';
                                    tr.style.transform = 'translateX(20px)';
                                    setTimeout(() => tr.remove(), 400);

                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Data removed successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }).catch(err => {
                                    form.submit(); // fallback
                                });
                            } else {
                                form.submit(); // not a table row
                            }
                        }
                    });
                }
            }
        });
    </script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('sidebarSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    filterSidebarMenu(this.value);
                });
            }
        });

        function filterSidebarMenu(query) {
            var q = query.toLowerCase().trim();
            var items = document.querySelectorAll('#sidebarNav li[data-menu]');
            var hasMatch = false;
            items.forEach(function (li) {
                var label = (li.getAttribute('data-menu') || '').toLowerCase();
                var show = (q === '' || label.includes(q));
                li.style.display = show ? '' : 'none';
                if (show) hasMatch = true;
            });
        }
    </script>
</body>

</html>