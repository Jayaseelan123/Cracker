<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CrackerTime')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-black: #e9dada;
            --primary-purple: #572eea;
        }

        body {
            background-color: #f8f9fa;
        }

        /* ---------------- HEADER ---------------- */
        .top-header {
            background: rgba(13, 107, 138, 0.95); /* Deep teal glass */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 0;
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
            height: 70px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .top-header a:not(.cart-btn) {
            color: #f8f9fa;
            text-decoration: none;
            margin-left: 25px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            padding-bottom: 5px;
            transition: color 0.3s ease;
        }

        .top-header a:not(.cart-btn):not(.btn)::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: linear-gradient(90deg, #ff9900, #ff3b3b);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .top-header a:not(.cart-btn):not(.btn):hover {
            color: #ff9900;
        }

        .top-header a:not(.cart-btn):not(.btn):hover::after {
            width: 100%;
        }

        .logo-text {
            color: #fff !important;
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 1.5px;
            background: linear-gradient(135deg, #ff9900, #ff3b3b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba(255, 153, 0, 0.3);
        }

        /* Header logo image (when company logo is uploaded) */
        .header-logo-img {
            max-height: 48px;
            max-width: 160px;
            object-fit: contain;
            display: block;
        }

        .cart-btn {
            background: linear-gradient(135deg, #ff9900, #ff3b3b);
            color: white;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 59, 59, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 59, 59, 0.4);
            color: white;
        }

        /* ---------------- MOBILE MENU ---------------- */
        .mobile-burger {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #ffffff !important;
            background: none;
            border: none;
            cursor: pointer;
            margin-left: 15px;
            padding: 0;
        }

        .mobile-menu-container {
            position: fixed;
            top: 60px;
            left: 0;
            width: 100%;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-menu-container.open {
            max-height: 300px;
        }

        .mobile-menu-nav {
            display: flex;
            flex-direction: column;
            padding: 20px;
            gap: 15px;
        }

        .mobile-menu-nav a {
            color: #333333 !important;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            padding: 10px;
            border-bottom: 1px solid #f9f9f9;
            display: block;
        }

        @media (max-width: 991px) {
            .top-header .container {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                width: 100%;
                padding: 0 15px;
            }

            .logo-text {
                font-size: 20px;
            }
        }

        /* ---------------- HERO ---------------- */
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("{{ asset('images/hero2.jpg') }}");
            background-size: cover;
            background-position: center;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding-top: 60px;
            /* Offset for fixed header */
        }

        .hero-banner h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-banner p {
            font-size: 1.5rem;
            opacity: 0.9;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        /* ================= MOBILE ================= */
        @media screen and (max-width: 768px) {
            .hero-banner { height: 350px; }
            .hero-banner h1 { font-size: 2.2rem; }
            .hero-banner p { font-size: 1.1rem; }
        }
    </style>

    @stack('head')
</head>

<body>

    @php $__companyHeader = \App\Models\CompanyDetail::first(); @endphp

    <!-- HEADER -->
    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">
            {{-- Show uploaded logo image if set, otherwise show text --}}
            @if($__companyHeader && $__companyHeader->logo)
                <a href="{{ url('/') }}" style="line-height:0;">
                    <img src="{{ asset($__companyHeader->logo) }}"
                         alt="{{ $__companyHeader->company_name ?? 'CrackerTime' }}"
                         class="header-logo-img">
                </a>
            @else
                <div class="fw-bold logo-text">{{ $__companyHeader->company_name ?? 'CRACKERTIME' }}</div>
            @endif

            <!-- Desktop Nav -->
            <div class="d-none d-lg-block ms-auto me-4">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/blog') }}">Blog</a>
                <a href="{{ url('/contact') }}">Contact</a>
                @if(\App\Models\SiteSetting::bool('show_pricelist_download', true))
                <a href="{{ route('download.products') }}" class="btn rounded-pill ms-2" style="background-color: #ff9900; color: #fff !important; padding: 6px 16px; font-weight: 600; font-size: 14px; text-decoration: none;">
                    <i class="fas fa-download me-1"></i> Products List
                </a>
                @endif
            </div>

            <!-- Mobile Actions -->
            <div class="d-flex d-lg-none align-items-center">
                <button class="mobile-burger" id="mobileBurgerBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Container -->
    <div class="mobile-menu-container d-lg-none" id="mobileMenuContainer">
        <div class="mobile-menu-nav">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/about') }}">About</a>
            <a href="{{ url('/blog') }}">Blog</a>
            <a href="{{ url('/contact') }}">Contact</a>
            @if(\App\Models\SiteSetting::bool('show_pricelist_download', true))
            <div class="p-3">
                <a href="{{ route('download.products') }}" class="btn w-100 rounded-pill" style="background-color: #ff9900; color: #fff !important; padding: 10px; font-weight: 600; text-align: center; border-bottom: none;">
                    <i class="fas fa-download me-1"></i> Download Products List
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- HERO -->
    <div class="hero-banner" id="hero-section">
        <div>
            <h1 id="hero-title">@yield('hero_title', 'Happy Diwali')</h1>
            <p id="hero-subtitle">@yield('hero_subtitle', 'Festival of Lights')</p>
        </div>
    </div>

    <br>

    <!-- MAIN CONTENT -->
    <div class="container my-4" id="content-section">
        @yield('content')
    </div>

    {{-- FOOTER: Common UI --}}
    @include('layouts.partials.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ✅ FIXED AJAX SINGLE PAGE LOADER -->
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            attachAjaxLinks();

            // Mobile menu toggle
            const mobileBurgerBtn = document.getElementById('mobileBurgerBtn');
            const mobileMenuContainer = document.getElementById('mobileMenuContainer');
            if (mobileBurgerBtn) {
                mobileBurgerBtn.addEventListener('click', () => {
                    mobileMenuContainer.classList.toggle('open');
                });
            }
        });

        function attachAjaxLinks() {

            document.querySelectorAll("a[href]").forEach(link => {

                const href = link.getAttribute("href");

                // Skip external links & special pages
                if (
                    href.startsWith("http") ||
                    href.includes("cart") ||
                    href.includes("admin") ||
                    href.includes(".pdf") ||
                    href.includes("whatsapp") ||
                    link.target === "_blank"
                ) return;

                link.addEventListener("click", function (e) {
                    e.preventDefault();

                    // FIX HOME URL
                    let url = (href === "/" || href === "{{ url('/') }}") ? "/" : href;

                    loadPage(url);
                });
            });
        }

        function loadPage(url) {

            fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
                .then(res => res.text())
                .then(html => {

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");

                    // Update hero title
                    const newTitle = doc.querySelector("#hero-title")?.textContent;
                    if (newTitle) document.querySelector("#hero-title").textContent = newTitle;

                    // Update subtitle
                    const newSubtitle = doc.querySelector("#hero-subtitle")?.textContent;
                    if (newSubtitle) document.querySelector("#hero-subtitle").textContent = newSubtitle;

                    // Update main content
                    const newContent = doc.querySelector("#content-section")?.innerHTML;
                    if (newContent) document.querySelector("#content-section").innerHTML = newContent;

                    // Change URL without reload
                    history.pushState({}, "", url);

                    // Re-attach AJAX to new links
                    attachAjaxLinks();

                    // Scroll to top
                    window.scrollTo(0, 0);
                })
                .catch(err => {
                    console.error("AJAX Failed:", err);
                    window.location.href = url; // fallback normal load
                });
        }

    </script>

    @stack('scripts')

</body>

</html>