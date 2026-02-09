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
            background-color: #0d6b8a;
            /* Teal as in footer */
            color: #ffffff;
            padding: 0;
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
            height: 60px;
            /* Standardize height */
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .top-header a:not(.cart-btn) {
            color: #ffffff;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
            transition: opacity 0.3s ease;
        }

        .top-header a:not(.cart-btn):hover {
            opacity: 0.8;
            color: #ffffff;
        }

        .logo-text {
            color: #ffffff !important;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .cart-btn {
            background-color: #ff9800;
            color: white;
            padding: 8px 14px;
            border-radius: 30px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
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

        @media screen and (max-width: 768px) {
            .hero-banner {
                height: 350px;
            }

            .hero-banner h1 {
                font-size: 2.2rem;
            }

            .hero-banner p {
                font-size: 1.1rem;
            }
        }

        /* ================= FOOTER MAIN ================= */
        .site-footer {
            background: #0d6b8a;
            color: #fff;
            padding: 50px 0 20px;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }

        /* Layout */
        .footer-container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 1fr 2fr;
            gap: 50px;
        }

        /* ================= LOGO ================= */
        .footer-logo {
            background: #ffffff;
            color: #ff8c00;
            font-size: 26px;
            font-weight: bold;
            padding: 20px 50px;
            display: inline-block;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        /* Tagline */
        .footer-tagline {
            line-height: 1.6;
            max-width: 420px;
            opacity: .9;
            color: #fff;
            margin-bottom: 0;
        }

        /* ================= HEADINGS ================= */
        .site-footer h4 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #fff;
            font-weight: bold;
        }

        /* ================= LINKS ================= */
        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* ================= CONTACT ================= */
        .footer-contact p {
            margin-bottom: 12px;
            line-height: 1.6;
            color: #fff;
        }

        /* ================= LATEST POSTS ================= */
        .latest-posts p {
            margin-bottom: 6px;
            line-height: 1.6;
        }

        /* ================= DIVIDER ================= */
        .footer-line {
            border-top: 1px solid rgba(255, 255, 255, .3);
            margin: 35px 0 15px;
        }

        /* ================= COPYRIGHT ================= */
        .footer-copy {
            text-align: center;
            font-size: 15px;
            opacity: .9;
            color: #fff;
        }

        /* ================= MOBILE ================= */
        @media(max-width:768px) {
            .footer-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-logo {
                margin: auto auto 15px;
                display: table;
            }
        }
    </style>

    @stack('head')
</head>

<body>

    <!-- HEADER -->
    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="fw-bold logo-text">CRACKERTIME</div>

            <!-- Desktop Nav -->
            <div class="d-none d-lg-block ms-auto me-4">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/blog') }}">Blog</a>
                <a href="{{ url('/contact') }}">Contact</a>
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

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-container">
            <!-- Logo & Tagline -->
            <div>
                <div class="footer-logo">CrackerTime</div>
                <p class="footer-tagline">Premium quality crackers for all your celebrations. Safe, colorful, and
                    memorable moments guaranteed.</p>

                <div class="latest-posts" style="margin-top:20px;">
                    <h4>Latest Posts</h4>
                    <p><a href="{{ route('blog') }}#science-behind-the-sparkle"
                            style="color:white; text-decoration:none;">The Science Behind the Sparkle</a></p>
                    <p><a href="{{ route('blog') }}#eco-friendly-crackers-2025"
                            style="color:white; text-decoration:none;">Top 10 Eco-Friendly Crackers</a></p>
                    <p><a href="{{ route('blog') }}#cracker-safety-guide"
                            style="color:white; text-decoration:none;">Ultimate Guide to Cracker Safety</a></p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('blog') }}">Blogs</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
                <h4>Contact Info</h4>
                <p><i class="fas fa-phone"></i> +919488864547</p>
                <p><i class="fas fa-envelope"></i> crackerstime.com@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Door No 2/554/C3, Southside school Near Sivakasi to Sattur main
                    road, Mettamalai, Sivakasi - 626203</p>
            </div>
        </div>

        <div class="footer-line"></div>
        <div class="footer-copy">© 2025 Crackers Time. All rights reserved. | Delivery Available</div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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