<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CrackerTime Clone')</title>

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

        /* ---------------- PREMIUM NAVBAR DROPDOWN ---------------- */
        .dropdown-toggle::after {
            display: none; /* Hide default arrow */
        }

        .dropdown-menu {
            display: block;
            visibility: hidden;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0,0,0,0.05) !important;
            width: fit-content !important;
            min-width: 150px !important;
            max-width: 280px !important;
            max-height: 300px; /* Scroll only */
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .dropdown-menu::-webkit-scrollbar {
            width: 4px;
        }
        .dropdown-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dropdown:hover .dropdown-menu {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-item {
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            font-size: 0.85rem !important; /* Reduced font size */
            padding: 8px 12px !important; /* Reduced padding */
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(13, 107, 138, 0.05);
            z-index: -1;
            transition: width 0.3s ease;
            border-radius: 8px;
        }

        .dropdown-item:hover {
            color: #0d6b8a !important;
            transform: translateX(5px);
            background: transparent !important;
        }

        .dropdown-item:hover::before {
            width: 100%;
        }

        .dropdown-icon {
            transition: transform 0.3s ease;
            font-size: 10px;
            margin-top: 2px;
        }

        .dropdown:hover .dropdown-icon {
            transform: rotate(180deg);
            color: #ff9900;
        }

        /* ---------------- HERO BANNER SLIDER ---------------- */
        .hero-slider {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
            margin-top: 70px;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }

        .hero-slide.active {
            opacity: 1;
            z-index: 2;
        }

        .hero-slide img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.45) 0%, rgba(0,0,0,0.2) 100%);
            z-index: 1;
        }

        .hero-slide-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-slide-content h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 10px;
            text-shadow: 2px 2px 15px rgba(0,0,0,0.5);
            animation: slideUp 0.8s ease forwards;
        }

        .hero-slide-content p {
            font-size: 1.5rem;
            opacity: 0.95;
            text-shadow: 1px 1px 8px rgba(0,0,0,0.4);
            animation: slideUp 0.8s 0.2s ease forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Slider Navigation Dots */
        .hero-slider-dots {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            gap: 10px;
        }

        .hero-slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            border: 2px solid rgba(255,255,255,0.8);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hero-slider-dot.active {
            background: #ff9900;
            border-color: #ff9900;
            transform: scale(1.2);
        }

        /* Slider Arrow Buttons */
        .hero-slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(5px);
            border: none;
            color: #fff;
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-slider-arrow:hover {
            background: rgba(255,153,0,0.8);
            transform: translateY(-50%) scale(1.1);
        }

        .hero-slider-arrow.prev { left: 20px; }
        .hero-slider-arrow.next { right: 20px; }

        /* Fallback static hero when no banners */
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("{{ asset('images/hero2.jpg') }}");
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            text-align: center;
            margin-top: 70px;
        }

        .hero-banner h1 {
            font-size: 3rem;
            font-weight: 900;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            margin-bottom: 5px;
        }

        .hero-banner p {
            font-size: 1.3rem;
            opacity: 0.9;
        }

        /* ---------------- CATEGORY EXPLORER ---------------- */
        .category-explorer-section {
            padding: 40px 0;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #134e5e 0%, #71b280 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .title-underline {
            width: 80px;
            height: 4px;
            background: #ffcc00; /* Yellow underline like the image */
            margin: 0 auto;
            border-radius: 2px;
        }

        .category-grid {
            display: flex;
            flex-wrap: nowrap; /* Change to nowrap for carousel */
            justify-content: flex-start;
            gap: 30px;
            padding: 20px 60px; /* Padding for arrows */
        }

        .category-carousel-container {
            position: relative;
            width: 100%;
        }

        .carousel-scroll {
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE and Edge */
            scroll-snap-type: x mandatory;
        }

        .carousel-scroll::-webkit-scrollbar {
            display: none; /* Chrome/Safari */
        }

        .category-card {
            flex: 0 0 auto; /* Prevent shrinking */
            scroll-snap-align: center;
            text-decoration: none !important;
            color: #333;
            text-align: center;
            width: 160px;
            transition: transform 0.3s ease;
        }

        .carousel-nav-btn {
            position: absolute;
            top: 40%;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            background: #fff;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 10;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d6b8a;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .carousel-nav-btn:hover {
            background: #ffcc00;
            color: #fff;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-nav-btn.prev { left: 5px; }
        .carousel-nav-btn.next { right: 5px; }

        .category-card {
            text-decoration: none !important;
            color: #333;
            text-align: center;
            width: 160px;
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-10px);
        }

        .category-img-container {
            width: 140px;
            height: 140px;
            border-radius: 50%; /* Circular like the image */
            overflow: hidden;
            margin: 0 auto 15px;
            border: 5px solid #fff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            background: #f8f9fa;
            transition: border-color 0.3s ease;
        }

        .category-card:hover .category-img-container {
            border-color: #ffcc00;
        }

        .category-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover img {
            transform: scale(1.15);
        }

        .category-card-name {
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #444;
            line-height: 1.3;
        }

        @media (max-width: 768px) {
            .category-card {
                width: 120px;
            }
            .category-img-container {
                width: 100px;
                height: 100px;
            }
            .section-title {
                font-size: 1.8rem;
            }
        }

        .category-header {
            background: linear-gradient(90deg, #0d6b8a 0%, #1a8ab0 100%);
            color: white;
            padding: 18px 30px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 50px;
            margin-bottom: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 30px rgba(13, 107, 138, 0.2);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: slideInLeft 0.8s ease-out forwards;
            border-left: 6px solid #ff9900;
        }

        .category-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .category-header:hover {
            transform: translateX(10px) scale(1.01);
            box-shadow: 0 15px 40px rgba(13, 107, 138, 0.3);
        }

        .category-header:hover::before {
            left: 100%;
        }

        .category-header i {
            font-size: 1.4rem;
            color: #ff9900;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .product-table th {
            background-color: #eee;
        }

        .product-row {
            border-bottom: 1px solid #ddd;
            background: white;
        }

        .product-row img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9em;
        }

        .new-price {
            color: green;
            font-weight: bold;
            font-size: 1.1em;
        }

        /* CART BUTTON */
        .cart-btn {
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 87, 34, 0.4);
            color: white;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #e53935;
            color: white;
            font-size: 11px;
            padding: 4px 6px;
            border-radius: 50%;
            font-weight: bold;
            min-width: 20px;
            text-align: center;
            border: 2px solid #fff;
        }

        /* Quantity controls (compact) - ensure available without asset build */
        .qty-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
            border: 2px solid #ddd;
            cursor: pointer;
            background: transparent;
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .qty-btn.minus {
            background: #ef5350;
            color: #fff;
            border-color: #e53935;
        }

        .qty-btn.minus:hover {
            background: #e53935;
        }

        .qty-btn.plus {
            background: #28a745;
            color: #fff;
            border-color: #218838;
        }

        .qty-btn.plus:hover {
            background: #218838;
        }

        .qty-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            background: #fff;
            padding: 4px 8px;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        @media (max-width: 480px) {
            .qty-controls {
                gap: 6px;
            }

            .qty-btn {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }

            .qty-input {
                width: 50px;
                height: 36px;
                font-size: 14px;
            }
        }

        /* ---------------- CART DRAWER ---------------- */
        #rightCartPanel {
            position: fixed;
            top: 0;
            right: -420px;
            width: 420px;
            height: 100%;
            background: #fff;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.2);
            z-index: 3000;
            padding: 20px;
            overflow-y: auto;
            transition: right .35s ease;
        }

        #rightCartPanel.open {
            right: 0;
        }

        #rightCartPanel .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            font-size: 18px;
        }

        #rightCartPanel .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
        }

        /* ---------------- CART IMAGE SAFE ---------------- */
        .cart-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        /* ---------------- RESPONSIVE RULES ---------------- */

        /* MOBILE & TABLET HEADER */
        @media (max-width: 991px) {
            .top-header {
                height: auto;
                min-height: 60px;
                padding: 10px 0;
            }

            .top-header .container {
                flex-wrap: wrap;
                gap: 10px;
                justify-content: space-between;
            }

            .top-header a {
                margin-left: 10px;
                font-size: 14px;
                display: inline-block;
                padding: 5px 0;
            }
        }

        @media (max-width: 575px) {
            .top-header .container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }

        /* MOBILE HERO */
        @media (max-width: 575px) {
            .hero-slider {
                height: 300px;
                margin-top: 60px;
            }

            .hero-slide-content h1 {
                font-size: 1.8rem;
            }

            .hero-slide-content p {
                font-size: 1rem;
            }

            .hero-slider-arrow {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }

            .hero-banner {
                height: 220px;
                background-attachment: scroll;
            }

            .hero-banner h1 {
                font-size: 24px;
            }
        }

        /* MAKE DRAWER 100% WIDTH ON MOBILE */
        @media (max-width: 575px) {
            #rightCartPanel {
                width: 100% !important;
                right: -100%;
            }

            #rightCartPanel.open {
                right: 0 !important;
            }
        }

        /* TABLE RESPONSIVE */
        @media (max-width: 768px) {
            #rightCartPanel table {
                font-size: 13px;
            }

            #rightCartPanel th,
            #rightCartPanel td {
                padding: 6px;
            }

            .cart-thumb {
                width: 50px;
                height: 50px;
            }

            .btn-sm {
                padding: 4px 8px !important;
                font-size: 12px !important;
            }

            .form-control {
                height: 30px !important;
                font-size: 12px;
            }
        }

        /* TABLET OPTIMIZED */
        @media (min-width: 576px) and (max-width: 991px) {
            #rightCartPanel {
                width: 350px;
            }
        }




        /* Cleaned duplicate cart button css */


        /* MOBILE MEDIA QUERY */
        @media screen and (max-width: 991px) {
            .top-header {
                height: 60px !important;
                padding: 0 !important;
                display: flex;
                align-items: center;
                border-bottom: 1px solid #f0f0f0;
            }

            .top-header .container {
                display: flex !important;
                flex-direction: row !important;
                /* FORCE ROW */
                justify-content: space-between !important;
                align-items: center !important;
                width: 100%;
                padding: 0 15px;
                position: relative;
            }

            /* Burger Button */
            .mobile-burger {
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 24px;
                color: #ffffff !important; /* White Burger */
                background: none;
                border: none;
                cursor: pointer;
                margin-left: 15px; /* Space from cart */
                padding: 0;
            }

            /* Logo - Left Aligned */
            .fw-bold.logo-text {
                position: static !important;
                width: auto !important; /* Prevent 100% width */
                margin-bottom: 0 !important;
                text-align: left;
                font-size: 22px; /* Slightly smaller to fit */
                font-weight: 800;
                white-space: nowrap;
                color: #ffffff !important; /* Force White on Teal */
                transform: none !important;
            }

            /* Cart Button Mobile */
            #openCartDrawerBtn.cart-btn {
                position: relative;
                width: 40px;
                height: 40px;
                padding: 0;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #ff9800;
            }

            #openCartDrawerBtn .cart-text {
                display: none;
            }

            #openCartDrawerBtn i {
                font-size: 18px;
                margin: 0;
            }

            #openCartDrawerBtn .cart-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                width: 18px;
                height: 18px;
                font-size: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px solid #fff;
            }

            /* Mobile Menu Dropdown */
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
                /* Adjust as needed */
            }

            .mobile-menu-nav {
                display: flex;
                flex-direction: column;
                padding: 20px;
                gap: 15px;
            }

            .mobile-menu-nav a {
                color: #333333 !important; /* Force Dark text on white bg */
                text-decoration: none;
                font-weight: 600;
                font-size: 16px;
                padding: 10px;
                border-bottom: 1px solid #f9f9f9;
                display: block;
            }

            /* Hide desktop spacer if it existed */
            .d-lg-none-spacer {
                display: none;
            }

            /* HERO Mobile Fix */
            .hero-slider {
                height: 350px !important;
                margin-top: 60px !important;
            }

            .hero-slide-content h1 {
                font-size: 2rem !important;
                line-height: 1.1;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
                margin-bottom: 15px;
            }

            .hero-slide-content p {
                font-size: 1.1rem !important;
                text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
                opacity: 0.95;
            }

            .hero-banner {
                height: 220px !important;
                margin-top: 60px !important;
            }
        }

        .site-footer .row {
            flex-direction: column;
            align-items: center;
        }

        .site-footer .col-md-5,
        .site-footer .col-md-3,
        .site-footer .col-md-4 {
            width: 100%;
            text-align: center;
            margin-bottom: 25px;
        }

        .site-footer .footer-logo img {
            margin: 0 auto 15px;
        }
        }

        /* CARD LIST VIEW FOR MOBILE PRODUCTS */
        @media screen and (max-width: 768px) {
            .product-table thead {
                display: none;
            }

            .product-table,
            .product-table tbody,
            .product-table tr,
            .product-table td {
                display: block;
                width: 100%;
            }

            .product-table tr.product-row {
                background: white;
                margin-bottom: 20px;
                border: 1px solid #eee;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
                padding: 15px;
                position: relative;
                padding-left: 100px;
                /* Space for image */
                min-height: 110px;
            }

            /* Image positioning */
            .product-table td:first-child {
                position: absolute;
                left: 10px;
                top: 15px;
                width: 80px !important;
                height: 80px !important;
                padding: 0 !important;
                border: none;
            }

            .product-table td:first-child img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 8px;
            }

            /* Text content adjustment */
            .product-table td {
                padding: 0 !important;
                border: none !important;
            }

            /* Name */
            .product-table td:nth-child(2) {
                margin-bottom: 5px;
                font-size: 1.1rem;
                font-weight: 700;
                line-height: 1.2;
            }

            /* Prices */
            .product-table td:nth-child(3) {
                /* Old Price */
                display: inline-block;
                width: auto !important;
                margin-right: 10px;
                font-size: 0.9rem;
                color: #aaa;
                text-decoration: line-through;
            }

            .product-table td:nth-child(4) {
                /* New Price */
                display: inline-block;
                width: auto !important;
                font-size: 1.1rem;
                font-weight: 800;
                color: #2e7d32;
            }

            /* Qty Controls */
            .product-table td:nth-child(5) {
                margin-top: 10px;
            }

            .qty-controls {
                justify-content: flex-start !important;
            }

            .qty-btn {
                width: 36px;
                height: 36px;
                font-size: 18px;
            }

            .qty-input {
                height: 36px;
                font-size: 15px;
                width: 50px;
            }
        }
    </style>

</head>

<body>

    @php $__companyHeader = \App\Models\CompanyDetail::first(); @endphp

    <!-- HEADER -->
    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">

            {{-- Show uploaded company logo or fallback to text --}}
            @if($__companyHeader && $__companyHeader->logo)
                <a href="{{ url('/') }}" style="line-height:0;">
                    <img src="{{ asset($__companyHeader->logo) }}"
                         alt="{{ $__companyHeader->company_name ?? 'CrackerTime' }}"
                         class="header-logo-img">
                </a>
            @else
                <div class="fw-bold logo-text">{{ $__companyHeader->company_name ?? 'CRACKERTIME' }}</div>
            @endif

            <!-- Desktop Nav - Pushed to Right -->
            <div class="d-none d-lg-block ms-auto me-4">
                <a href="{{ url('/') }}">Home</a>

                @php $headerCats = \App\Models\Category::all(); @endphp
                <div class="dropdown d-inline-block">
                    <a href="#" class="dropdown-toggle d-flex align-items-center gap-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                        <i class="fas fa-chevron-down small dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-3" style="min-width: 220px;">
                        @foreach($headerCats as $hCat)
                        <li>
                            <a class="dropdown-item rounded-3 py-2 px-3 fw-semibold text-dark nav-category-link" 
                               href="{{ url('/') }}#cat-{{ $hCat->slug ?? Str::slug($hCat->name) }}">
                                {{ $hCat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/blog') }}">Blog</a>
                <a href="{{ url('/contact') }}">Contact</a>
                @if(\App\Models\SiteSetting::bool('show_pricelist_download', true))
                <a href="{{ route('download.products') }}" class="btn rounded-pill ms-2" style="background-color: #ff9900; color: #fff !important; padding: 6px 16px; font-weight: 600; font-size: 14px; text-decoration: none;">
                    <i class="fas fa-download me-1"></i> Products List
                </a>
                @endif
            </div>

            <!-- Right Actions (Cart + Burger) -->
            <div class="right-actions d-flex align-items-center">
                <a href="#" id="openCartDrawerBtn" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-text">View Cart</span>
                    <span class="cart-badge">{{ count((array) session('cart', [])) }}</span>
                </a>

                <!-- Mobile Burger (Now on Right) -->
                <button class="mobile-burger d-lg-none" id="mobileBurgerBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Container (Moved outside top-header) -->
    <div class="mobile-menu-container d-lg-none" id="mobileMenuContainer">
        <div class="mobile-menu-nav">
            <a href="{{ url('/') }}">Home</a>
            
            <div class="fw-bold px-2 py-2 text-primary small text-uppercase">Categories</div>
            @foreach(\App\Models\Category::all() as $mCat)
                <a href="{{ url('/') }}#cat-{{ $mCat->slug ?? Str::slug($mCat->name) }}" class="ps-4 nav-category-link">{{ $mCat->name }}</a>
            @endforeach

            <a href="{{ url('/about') }}">About</a>
            <a href="{{ url('/blog') }}">Blog</a>
            <a href="{{ url('/contact') }}">Contact</a>
            @if(\App\Models\SiteSetting::bool('show_pricelist_download', true))
            <div class="p-3">
                <a href="{{ route('download.products') }}" class="btn w-100 rounded-pill" style="background-color: #ff9900; color: #fff !important; padding: 10px; font-weight: 600; text-align: center; border-bottom: none;">
                    <i class="fas fa-download me-1"></i> Products List
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- HERO BANNER SLIDER -->
    @if(isset($banners) && $banners->count() > 0)
    <div class="hero-slider" id="heroSlider">
        @foreach($banners as $index => $banner)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
            <img src="{{ asset($banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}">
            <div class="hero-slide-overlay"></div>
            <div class="hero-slide-content">
                @if($banner->title)
                    <h1>{{ $banner->title }}</h1>
                @endif
                @if($banner->subtitle)
                    <p>{{ $banner->subtitle }}</p>
                @endif
            </div>
        </div>
        @endforeach

        @if($banners->count() > 1)
        <button class="hero-slider-arrow prev" id="sliderPrev"><i class="fas fa-chevron-left"></i></button>
        <button class="hero-slider-arrow next" id="sliderNext"><i class="fas fa-chevron-right"></i></button>
        <div class="hero-slider-dots" id="sliderDots">
            @foreach($banners as $index => $banner)
            <div class="hero-slider-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
            @endforeach
        </div>
        @endif
    </div>
    @else
    <div class="hero-banner">
        <div>
            <h1>@yield('hero_title', 'Happy Diwali')</h1>
            <p>@yield('hero_subtitle', 'Festival of Lights')</p>
        </div>
    </div>
    @endif

    <div class="container my-4">
        @yield('content')
    </div>

    <!-- RIGHT CART DRAWER (rendered from partial; initially server-side rendered then refreshed via AJAX) -->
    <div id="rightCartPanel">
        @include('front.partials.drawer', ['cart' => session('cart', [])])
    </div>

    {{-- FOOTER: Common UI --}}
    @include('layouts.partials.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {

            const openBtn = document.getElementById('openCartDrawerBtn');
            const panel = document.getElementById('rightCartPanel');
            const badge = document.querySelector('.cart-badge');

            const partialUrl = "{{ route('cart.view.partial') }}";
            const ajaxAddBase = "/cart/ajax/add/";
            const ajaxUpdateBase = "/cart/ajax/update/";
            const ajaxDecreaseBase = "/cart/ajax/decrease/";

            /* --------------------------- SAFE BADGE UPDATE --------------------------- */
            function updateBadge(cart) {
                let total = 0;

                try {
                    for (const id in cart) {
                        total += parseInt(cart[id] || 0);
                    }
                } catch (e) { }

                badge.innerText = total > 0 ? total : 0;
            }

            /* --------------------------- REFRESH DRAWER --------------------------- */
            function refreshDrawer(cart = null) {
                fetch(partialUrl)
                    .then(res => res.text())
                    .then(html => {
                        panel.innerHTML = html;
                        attachListeners();
                        if (cart) updateBadge(cart);
                    })
                    .catch(err => console.error("Drawer refresh failed", err));
            }

            /* --------------------------- ATTACH LISTENERS INSIDE DRAWER --------------------------- */
            function attachListeners() {

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                /* --- Close button --- */
                const closeBtn = panel.querySelector('#closeCartPanelPartial');
                if (closeBtn) closeBtn.addEventListener('click', () => panel.classList.remove('open'));

                /* --- Qty input (cdr-qty-input): update cart on change --- */
                panel.querySelectorAll('.cdr-qty-input').forEach(input => {
                    input.addEventListener('change', function () {
                        const id  = input.dataset.id;
                        const qty = Math.max(1, parseInt(input.value) || 1);
                        input.value = qty;

                        fetch(ajaxUpdateBase + id, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ quantity: qty })
                        })
                            .then(r => r.json())
                            .then(data => {
                                updateBadge(data.cart);
                                refreshDrawer(data.cart);
                            })
                            .catch(err => console.error('Qty update failed', err));
                    });
                });

                /* --- Drawer + button add (legacy support) --- */
                panel.querySelectorAll('.qty-plus').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        btn.disabled = true;
                        fetch(ajaxAddBase + id, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                        })
                            .then(r => r.json())
                            .then(data => { updateBadge(data.cart); refreshDrawer(data.cart); })
                            .finally(() => btn.disabled = false);
                    });
                });

                /* --- Drawer - button reduce (legacy support) --- */
                panel.querySelectorAll('.qty-minus').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        btn.disabled = true;
                        fetch(ajaxDecreaseBase + id, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' }
                        })
                            .then(r => r.json())
                            .then(data => { updateBadge(data.cart); refreshDrawer(data.cart); })
                            .finally(() => btn.disabled = false);
                    });
                });

                /* --- Drawer remove (×) button --- */
                panel.querySelectorAll('.qty-remove').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        btn.disabled = true;
                        fetch('/cart/ajax/remove/' + id, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                        })
                            .then(r => r.json())
                            .then(data => { updateBadge(data.cart); refreshDrawer(data.cart); })
                            .finally(() => btn.disabled = false);
                    });
                });

                /* --- Panel Toggles & Form Logic --- */
                const goToFormBtn = panel.querySelector('#cdrGoToForm');
                if (goToFormBtn) {
                    goToFormBtn.addEventListener('click', () => {
                        const p1 = panel.querySelector('#cdrPanel1');
                        const p2 = panel.querySelector('#cdrPanel2');
                        if (p1 && p2) {
                            p1.style.display = 'none';
                            p2.style.display = '';
                        }
                    });
                }

                const backBtn = panel.querySelector('#cdrBackBtn');
                if (backBtn) {
                    backBtn.addEventListener('click', () => {
                        const p1 = panel.querySelector('#cdrPanel1');
                        const p2 = panel.querySelector('#cdrPanel2');
                        if (p1 && p2) {
                            p2.style.display = 'none';
                            p1.style.display = '';
                        }
                    });
                }

                const stateSelect = panel.querySelector('#cdrStateSelect');
                if (stateSelect) {
                    stateSelect.addEventListener('change', () => {
                        var opt = stateSelect.options[stateSelect.selectedIndex];
                        if (!opt || !opt.value) {
                            cdrUpdateTotals(0, 0);
                            return;
                        }

                        var packing = parseFloat(opt.dataset.packing || 0);
                        var minOrder = parseFloat(opt.dataset.min || 0);
                        var allCities = opt.dataset.allcities === '1';
                        var cities = [];
                        try { cities = JSON.parse(opt.dataset.cities || '[]'); } catch(e){}

                        var citySelect = panel.querySelector('#cdrCitySelect');

                        if (citySelect) {
                            citySelect.innerHTML = '<option value="">-- Select District / City --</option>';
                            if (!allCities && cities.length > 0) {
                                // Specific cities → add them as options
                                cities.forEach(function(c) {
                                    var o = document.createElement('option');
                                    o.value = o.textContent = c;
                                    citySelect.appendChild(o);
                                });
                            } else {
                                // All Districts enabled → add "All Districts" as the single option
                                var o = document.createElement('option');
                                o.value = o.textContent = 'All Districts';
                                o.selected = true;
                                citySelect.appendChild(o);
                            }
                            // Ensure the dropdown is visible
                            citySelect.style.display = '';
                        }

                        cdrUpdateTotals(packing, minOrder);
                    });
                    
                    // Trigger change on load to populate cities if a state is already selected
                    if (stateSelect.value) {
                        stateSelect.dispatchEvent(new Event('change'));
                    }
                }

                function cdrUpdateTotals(packing, minOrder) {
                    var wrap = panel.querySelector('#cdrWrap');
                    var subtotalVal = parseFloat(wrap ? wrap.dataset.subtotal : 0) || 0;
                    var total = subtotalVal + packing;
                    var rounded = Math.round(total);
                    var roundOff = rounded - total;

                    var minRow = panel.querySelector('#cdrMinOrderRow');
                    var minVal = panel.querySelector('#cdrMinOrderVal');
                    if (minRow && minVal) {
                        if (minOrder > 0) {
                            minRow.style.display = '';
                            minVal.textContent = '₹\u00a0' + minOrder.toLocaleString('en-IN');
                        } else {
                            minRow.style.display = 'none';
                        }
                    }

                    var packRow = panel.querySelector('#cdrPackingRow');
                    var packLabel = panel.querySelector('#cdrPackingLabel');
                    var packVal = panel.querySelector('#cdrPackingVal');
                    if (packRow && packLabel && packVal) {
                        if (packing > 0) {
                            packRow.style.display = '';
                            packLabel.textContent = 'Packing Charges (' + packing + ')';
                            packVal.textContent = '₹\u00a0' + packing.toLocaleString('en-IN', {minimumFractionDigits:2});
                        } else {
                            packRow.style.display = 'none';
                        }
                    }

                    var roundOffEl = panel.querySelector('#cdrRoundOff');
                    if (roundOffEl) roundOffEl.textContent = '₹\u00a0' + roundOff.toFixed(2);

                    var overallAmtEl = panel.querySelector('#cdrOverallAmt');
                    if (overallAmtEl) overallAmtEl.textContent = '₹\u00a0' + rounded.toLocaleString('en-IN', {minimumFractionDigits:2});

                    var packingHiddenEl = panel.querySelector('#cdrPackingHidden');
                    if (packingHiddenEl) packingHiddenEl.value = packing;
                }

                const estimateForm = panel.querySelector('#cdrEstimateForm');
                if (estimateForm) {
                    estimateForm.addEventListener('submit', (e) => {
                        const stateSelect = panel.querySelector('#cdrStateSelect');
                        if (stateSelect) {
                            const opt = stateSelect.options[stateSelect.selectedIndex];
                            if (opt && opt.value) {
                                const minOrder = parseFloat(opt.dataset.min || 0);
                                const wrap = panel.querySelector('#cdrWrap');
                                const subtotalVal = parseFloat(wrap ? wrap.dataset.subtotal : 0) || 0;
                                
                                if (minOrder > 0 && subtotalVal < minOrder) {
                                    e.preventDefault();
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Minimum Order Requirement',
                                            html: 'Minimum order amount for <strong>' + opt.value + '</strong> is <strong>₹' + minOrder.toLocaleString('en-IN') + '</strong>.<br><br>Your current subtotal is <strong>₹' + subtotalVal.toLocaleString('en-IN') + '</strong>. Please add more items to proceed.',
                                            confirmButtonColor: '#8B1A1A'
                                        });
                                    } else {
                                        alert('Minimum order amount for ' + opt.value + ' is ₹' + minOrder.toLocaleString('en-IN') + '. Your subtotal is ₹' + subtotalVal.toLocaleString('en-IN') + '.');
                                    }
                                }
                            }
                        }
                    });
                }

            }

            /* --------------------------- OPEN DRAWER --------------------------- */
            openBtn.addEventListener('click', e => {
                e.preventDefault();
                refreshDrawer();
                panel.classList.add('open');
            });

            /* --------------------------- PRODUCT LIST + / - --------------------------- */
            document.addEventListener('click', function (e) {
                const el = e.target;
                if (!el) return;

                /* + button */
                if (el.matches('.qty-btn.plus')) {
                    e.stopImmediatePropagation();
                    const id = el.dataset.id;
                    el.disabled = true;

                    fetch("/cart/ajax/add/" + id, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            // Update qty display
                            const qtyDisplay = document.querySelector('.qty-display-' + id);
                            if (qtyDisplay && data.cart) {
                                qtyDisplay.value = data.cart[id] || 0;
                            }
                            updateBadge(data.cart);
                            refreshDrawer(data.cart);

                            // Show success message
                            showToast('product added to cart', 'success');
                        })
                        .finally(() => el.disabled = false);
                }

                /* - button */
                if (el.matches('.qty-btn.minus')) {
                    e.stopImmediatePropagation();
                    const id = el.dataset.id;
                    el.disabled = true;

                    fetch("/cart/ajax/decrease/" + id, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        // body: JSON.stringify({ action: "decrease" })
                    })
                        .then(r => r.json())
                        .then(data => {
                            // Update qty display
                            const qtyDisplay = document.querySelector('.qty-display-' + id);
                            if (qtyDisplay && data.cart) {
                                qtyDisplay.value = data.cart[id] || 0;
                            }
                            updateBadge(data.cart);
                            refreshDrawer(data.cart);

                            // Show success message
                            showToast('product reduced to cart', 'success');
                        })
                        .finally(() => el.disabled = false);
                }

                /* remove from product list (if exists) */
                if (el.matches('.qty-remove')) {
                    const id = el.dataset.id;
                    el.disabled = true;

                    fetch("/cart/ajax/remove/" + id, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            updateBadge(data.cart);
                            refreshDrawer(data.cart);
                        })
                        .finally(() => el.disabled = false);
                }

            });

        })();

        function updateQty(productId, change) {
            const qtyInput = document.getElementById(`qty-${productId}`);
            const qtyInputM = document.getElementById(`qty-m-${productId}`);
            let currentQty = parseInt(qtyInput.value) || 0;
            let newQty = Math.max(0, currentQty + change);

            // qtyInput.value = newQty;
            // qtyInputM.value = newQty;


            // Enhanced feedback animation
            qtyInput.classList.add('scale-110', 'bg-purple-50', 'border-purple-400');

            // Add ripple effect to button
            const button = event.target.closest('button');
            if (button) {
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 150);
            }

            setTimeout(() => {
                qtyInput.classList.remove('scale-110', 'bg-purple-50', 'border-purple-400');
            }, 300);

            // Show success message for mobile
            // if (window.innerWidth < 768 && newQty > currentQty) {
            //     showToast('Product added to cart!');
            // }

            // Call appropriate function
            if (change > 0) {
                // addToCart(productId, 1);
                fetch(`/cart/ajax/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (document.getElementById('cart-count')) {
                                document.getElementById('cart-count').innerText = data.cart_count || 0; // fallback
                            }
                            if (document.getElementById('cart-total')) {
                                document.getElementById('cart-total').innerText = data.cart_total || 0;
                            }
                            // Update inputs if they exist
                            if (qtyInput) qtyInput.value = newQty;
                            if (qtyInputM) qtyInputM.value = newQty;

                            // Also update drawer badge
                            //  const badge = document.querySelector('.cart-badge');
                            //  if(badge && data.cart) {
                            //      let total = 0; 
                            //      for(let k in data.cart) total += data.cart[k];
                            //      badge.innerText = total;
                            //  }

                            showToast('Product added to cart', 'success'); // ✅ Toast instead of alert
                        } else {
                            showToast(data.message || 'Error', 'error');
                        }
                    });
            } else if (currentQty > 0) {
                // reduceToCart(productId, 1);
                fetch(`/cart/ajax/decrease/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (document.getElementById('cart-count')) {
                                document.getElementById('cart-count').innerText = data.cart_count || 0;
                            }
                            if (document.getElementById('cart-total')) {
                                document.getElementById('cart-total').innerText = data.cart_total || 0;
                            }
                            if (qtyInput) qtyInput.value = newQty;
                            if (qtyInputM) qtyInputM.value = newQty;

                            showToast('product reduced to cart', 'success'); // ✅ Toast
                        } else {
                            showToast("Something went wrong", 'error');
                        }
                    });
            }
        }
        function showToast(message, type = 'success') {
            let toast = document.getElementById("main-toast");
            if (!toast) {
                toast = document.createElement("div");
                toast.id = "main-toast";
                toast.style.position = "fixed";
                toast.style.bottom = "20px";
                toast.style.right = "20px";  // Right side as requested
                toast.style.padding = "12px 18px";
                toast.style.borderRadius = "8px";
                toast.style.color = "#fff";
                toast.style.zIndex = "9999";
                toast.style.fontSize = "14px";
                toast.style.boxShadow = "0 4px 12px rgba(0,0,0,0.15)";
                toast.style.transition = "all 0.3s ease";
                document.body.appendChild(toast);
            }

            // Set colors based on type
            if (type === "success") {
                toast.style.background = "#28a745";  // Green for success
            } else if (type === "error") {
                toast.style.background = "#dc3545";   // Red for error
            } else {
                toast.style.background = "#17a2b8";   // Blue for info
            }

            toast.innerText = message;
            toast.style.display = "block";
            toast.style.opacity = "1";
            toast.style.transform = "translateX(0)";

            // Auto hide after 3 seconds
            setTimeout(() => {
                toast.style.opacity = "0";
                toast.style.transform = "translateX(20px)";
                setTimeout(() => {
                    toast.style.display = "none";
                }, 300);
            }, 3000);
        }



    </script>

    <script>
        // Toggle Mobile Menu
        const mobileBurgerBtn = document.getElementById('mobileBurgerBtn');
        const mobileMenuContainer = document.getElementById('mobileMenuContainer');
        if (mobileBurgerBtn) {
            mobileBurgerBtn.addEventListener('click', () => {
                mobileMenuContainer.classList.toggle('open');
            });
        }

        // Smooth Scroll for Category Links
        document.querySelectorAll('.nav-category-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.includes('#cat-')) {
                    const targetId = href.split('#')[1];
                    const targetEl = document.getElementById(targetId);
                    
                    if (targetEl && (window.location.pathname === '/' || window.location.pathname === '{{ url('/') }}')) {
                        e.preventDefault();
                        
                        // Close mobile menu if it's open
                        if (mobileMenuContainer) mobileMenuContainer.classList.remove('open');
                        
                        const offset = 90; // Fixed header offset
                        const elementPosition = targetEl.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Optional: Update URL hash without jumping
                        history.pushState(null, null, '#' + targetId);
                    }
                }
            });
        });

        // Category Carousel Logic
        const catCarousel = document.getElementById('catCarousel');
        const catPrev = document.getElementById('catPrev');
        const catNext = document.getElementById('catNext');

        if (catCarousel && catPrev && catNext) {
            catNext.addEventListener('click', () => {
                catCarousel.scrollBy({ left: 300, behavior: 'smooth' });
            });
            catPrev.addEventListener('click', () => {
                catCarousel.scrollBy({ left: -300, behavior: 'smooth' });
            });

            // Hide arrows if not scrollable
            const toggleArrows = () => {
                catPrev.style.display = catCarousel.scrollLeft <= 0 ? 'none' : 'flex';
                catNext.style.display = catCarousel.scrollLeft + catCarousel.clientWidth >= catCarousel.scrollWidth ? 'none' : 'flex';
            };
            catCarousel.addEventListener('scroll', toggleArrows);
            window.addEventListener('resize', toggleArrows);
            toggleArrows();
        }
    </script>

    <!-- Banner Slider Script -->
    <script>
    (function() {
        const slider = document.getElementById('heroSlider');
        if (!slider) return;

        const slides = slider.querySelectorAll('.hero-slide');
        const dots = slider.querySelectorAll('.hero-slider-dot');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');

        if (slides.length <= 1) return;

        let currentSlide = 0;
        let autoPlayInterval;

        function goToSlide(index) {
            slides[currentSlide].classList.remove('active');
            if (dots[currentSlide]) dots[currentSlide].classList.remove('active');

            currentSlide = (index + slides.length) % slides.length;

            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }

        // Arrow buttons
        if (nextBtn) nextBtn.addEventListener('click', function() { stopAutoPlay(); nextSlide(); startAutoPlay(); });
        if (prevBtn) prevBtn.addEventListener('click', function() { stopAutoPlay(); prevSlide(); startAutoPlay(); });

        // Dot navigation
        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                stopAutoPlay();
                goToSlide(parseInt(this.dataset.slide));
                startAutoPlay();
            });
        });

        // Pause on hover
        slider.addEventListener('mouseenter', stopAutoPlay);
        slider.addEventListener('mouseleave', startAutoPlay);

        // Start auto-play
        startAutoPlay();
    })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

</body> 

</html>