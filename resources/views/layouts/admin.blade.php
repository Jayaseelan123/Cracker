<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    @php $__companyFavicon = \App\Models\CompanyDetail::first(); @endphp
    @if($__companyFavicon && $__companyFavicon->favicon)
        <link rel="icon" href="{{ asset($__companyFavicon->favicon) }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== SIDEBAR — Dark Bokeh Background ===== */
        .sidebar {
            height: 100vh;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(80, 60, 140, 0.55) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 10%, rgba(40, 80, 160, 0.45) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 70%, rgba(30, 60, 120, 0.50) 0%, transparent 55%),
                radial-gradient(ellipse at 10% 80%, rgba(60, 40, 110, 0.40) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 90%, rgba(20, 50, 100, 0.45) 0%, transparent 45%),
                linear-gradient(160deg, #0f1b2d 0%, #111827 40%, #0c1524 70%, #080e1a 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.07);
            position: fixed;
            width: 250px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.5);
        }

        /* Subtle animated bokeh orbs via pseudo element */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 35%, rgba(120, 100, 200, 0.18) 0%, transparent 35%),
                radial-gradient(circle at 75% 55%, rgba(60, 120, 220, 0.14) 0%, transparent 30%),
                radial-gradient(circle at 45% 85%, rgba(80, 60, 160, 0.16) 0%, transparent 28%),
                radial-gradient(circle at 85% 20%, rgba(40, 80, 180, 0.12) 0%, transparent 25%);
            pointer-events: none;
            z-index: 0;
        }

        .sidebar>* {
            position: relative;
            z-index: 1;
        }

        /* Header */
        .sidebar .p-3.text-center {
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.10) !important;
            color: #fff !important;
        }

        .sidebar .p-3.text-center img {
            filter: brightness(1.1) drop-shadow(0 0 6px rgba(255, 255, 255, 0.2));
        }

        .sidebar .p-3.text-center span {
            color: #e2e8f0 !important;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        /* Scrollable nav */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            list-style: none;
            padding: 6px 0;
            margin: 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.18);
            border-radius: 4px;
        }

        /* Nav links */
        .sidebar a {
            display: block;
            padding: 11px 18px;
            color: rgba(220, 230, 255, 0.82);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.88rem;
            letter-spacing: 0.2px;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(111, 66, 193, 0.35);
            color: #ffffff;
            border-left: 3px solid #a78bfa;
            text-shadow: 0 0 8px rgba(167, 139, 250, 0.4);
        }

        /* Footer */
        .sidebar .sidebar-footer {
            background: rgba(0, 0, 0, 0.25);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar .sidebar-footer a {
            display: block;
            padding: 14px 18px;
            color: rgba(200, 210, 255, 0.75);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.88rem;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .sidebar .sidebar-footer a:hover {
            background: rgba(111, 66, 193, 0.35);
            color: #fff;
            border-left: 3px solid #a78bfa;
        }

        /* Search bar inside sidebar */
        #sidebarSearch {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #e2e8f0 !important;
            border-radius: 8px !important;
        }

        #sidebarSearch::placeholder {
            color: rgba(200, 210, 255, 0.5) !important;
        }

        #sidebarSearch:focus {
            border-color: rgba(167, 139, 250, 0.6) !important;
            background: rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 0 0 2px rgba(167, 139, 250, 0.2) !important;
        }

        .sidebar .px-3 .fa-search {
            color: rgba(200, 210, 255, 0.5) !important;
        }

        /* ===== MAIN CONTENT ===== */
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

        /* ===== TOP NAVBAR ===== */
        .admin-topbar {
            background: linear-gradient(135deg, #0f1b2d 0%, #1a1f35 50%, #111827 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.35) !important;
            border-radius: 12px !important;
        }

        .admin-topbar .navbar-brand {
            color: #e2e8f0 !important;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.3px;
        }

        .admin-topbar .fw-medium {
            color: #cbd5e1 !important;
        }

        .admin-topbar .dropdown-toggle::after {
            border-top-color: #94a3b8;
        }

        /* ===== RESPONSIVE MEDIA QUERIES ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 1040;
            }

            .sidebar.show-sidebar {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            /* Overlay for mobile sidebar */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1030;
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
            }

            .sidebar-overlay.show-overlay {
                display: block;
                opacity: 1;
            }
        }

        /* Fix SweetAlert overlap on mobile admin */
        .swal2-container {
            z-index: 99999 !important;
        }
    </style>
    @stack('head')
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PC8T27KQ');</script>
    <!-- End Google Tag Manager -->
</head>

<body class="overflow-x-hidden" style="overflow-x: hidden;">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PC8T27KQ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar" id="adminSidebar">
        {{-- Header --}}
        <div class="p-3 text-center fw-bold text-purple border-bottom flex-shrink-0">
            @php $adminCompany = \App\Models\CompanyDetail::first(); @endphp
            @if($adminCompany && $adminCompany->logo)
                <img src="{{ asset($adminCompany->logo) }}" alt="{{ $adminCompany->name ?? 'Company Logo' }}"
                    style="max-height: 50px; max-width: 100%; object-fit: contain;">
            @elseif($adminCompany && $adminCompany->name)
                <span class="fs-5">{{ $adminCompany->name }}</span>
            @else
                <i class="fas fa-fire"></i> ADMIN PANEL
            @endif
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
                    class="nav-link {{ request()->routeIs('orders.index') || request()->routeIs('admin.orders.view') || request()->routeIs('admin.orders.pdf') ? 'active' : '' }}">
                    <i class="fa fa-shopping-cart me-2"></i> Orders
                </a>
            </li>
            <!-- <li class="nav-item" data-menu="direct enquiry">
                <a href="{{ route('admin.direct.enquiry') }}"
                    class="nav-link {{ request()->routeIs('admin.direct.enquiry') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane me-2"></i> Direct Customer
                </a>
            </li> -->
            <li class="nav-item" data-menu="enquiry customer">
                <a href="{{ route('admin.enquiry.customer') }}"
                    class="nav-link {{ request()->routeIs('admin.enquiry.customer') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Order Enquiry
                </a>
            </li>
            <!-- <li class="nav-item" data-menu="blog posts">
                <a href="{{ route('admin.blogs.index') }}"
                    class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-blog me-2"></i> Blog Posts
                </a>
            </li> -->
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
        <nav class="navbar admin-topbar navbar-dark mb-4 flex-nowrap">
            <div class="container-fluid flex-nowrap">
                <div class="d-flex align-items-center overflow-hidden">
                    <button class="btn d-lg-none me-2 me-sm-3 flex-shrink-0" type="button" id="sidebarToggleBtn"
                        style="border: none; padding: 6px 12px; background: rgba(255,255,255,0.08); border-radius: 8px; color: #fff;">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <span class="navbar-brand mb-0 h1 text-truncate"
                        style="font-size: 1.1rem; max-width: 200px;">@yield('header', 'Dashboard')</span>
                </div>
                <div class="dropdown ms-2 flex-shrink-0">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                        role="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 38px; height: 38px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <span
                            class="fw-medium text-white ms-2 d-none d-sm-inline">{{ auth()->user()?->name ?? 'Admin' }}</span>
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

        // Sidebar Toggle Logic
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggleBtn && sidebar && overlay) {
                function toggleSidebar() {
                    sidebar.classList.toggle('show-sidebar');
                    if (sidebar.classList.contains('show-sidebar')) {
                        overlay.style.display = 'block';
                        // small delay for transition
                        setTimeout(() => overlay.classList.add('show-overlay'), 10);
                    } else {
                        overlay.classList.remove('show-overlay');
                        setTimeout(() => overlay.style.display = 'none', 300);
                    }
                }

                toggleBtn.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>

</html>