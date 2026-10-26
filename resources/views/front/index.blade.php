@extends('layouts.app')

@section('title', 'Buy Sivakasi Crackers Online at Kasthuri Crackers')
@section('meta_description', 'Shop the widest range of online crackers Sivakasi has to offer. Kasthuri Crackers brings quality Diwali fireworks to your doorstep at wholesale prices.')

@section('hero_title', 'Welcome to CrackerTime')
@section('hero_subtitle', 'Shop the best festive crackers')

@section('content')
    <!-- CATEGORIES EXPLORER (Image Style) -->
    @if(\App\Models\SiteSetting::bool('enable_category_filter', true))
        <div class="category-explorer-section mb-5">
            <div class="section-title-wrapper text-center mb-4">
                <h2 class="section-title">Explore Categories</h2>
                <div class="title-underline"></div>
            </div>

            <!-- CATEGORY SEARCH BAR -->
            <div class="search-filter-container container mb-4" style="max-width: 500px;">
                <div class="input-group shadow-sm rounded-pill overflow-hidden border" style="background:#fff;">
                    <span class="input-group-text bg-white border-0 ps-3">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="categorySearchInput" class="form-control border-0 py-2 ps-2"
                        placeholder="Search categories..." style="outline: none; box-shadow: none;">
                    <button class="btn border-0 bg-white pe-3" type="button" id="clearCategorySearchBtn" style="display: none;">
                        <i class="fas fa-times text-muted"></i>
                    </button>
                </div>
            </div>
            <div id="noCategoriesMsg" class="text-center text-muted mb-4" style="display: none;">
                <h5 class="mb-0">No Categories Found</h5>
            </div>

            <div class="category-carousel-container">
                <button class="carousel-nav-btn prev" id="catPrev"><i class="fas fa-chevron-left"></i></button>
                <div class="category-grid carousel-scroll" id="catCarousel">
                    @foreach($categories as $category)
                        @php 
                                                                                                                                                                                    $catImg = $category->image ? asset('category_images/' . $category->image) : asset('images/category.png');
                            $catSlug = $category->slug ?? Str::slug($category->name);
                        @endphp
                        <a href="{{ route('front.products') }}#cat-{{ $catSlug }}" class="category-card">
                            <div class="category-img-container">
                                <img src="{{ $catImg }}" alt="{{ $category->name }}">
                            </div>
                            <div class="category-card-name">{{ $category->name }}</div>
                        </a>
                    @endforeach
                </div>
                <button class="carousel-nav-btn next" id="catNext"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    @endif

    <!-- Shop CTA Banner -->
    <!-- <div class="text-center py-5 my-4" style="background: linear-gradient(135deg, #0d6b8a 0%, #1a8ab0 100%); border-radius: 20px; box-shadow: 0 10px 40px rgba(13,107,138,0.2);">
                                        <i class="fas fa-fire fa-3x mb-3" style="color:#ff9900;"></i>
                                        <h3 class="fw-bold text-white mb-2">Explore Our Full Product Range</h3>
                                        <p class="text-white mb-4" style="opacity:0.85;">Browse all categories, search by name or code, and add directly to your cart.</p>
                                        <a href="{{ route('front.products') }}" class="btn btn-lg rounded-pill px-5 fw-bold" style="background: linear-gradient(135deg,#ff9900,#ff3b3b); color:#fff; box-shadow: 0 4px 20px rgba(255,153,0,0.4); font-size:1.1rem;">
                                            <i class="fas fa-shopping-bag me-2"></i> View All Products
                                        </a>
                                    </div> -->

    <!-- ============================================================
                                         SECTION 1 : SHOP BY OCCASION
                                    ============================================================ -->
    <div class="py-5 my-5">
        <div class="section-title-wrapper text-center mb-5">
            <h2 class="section-title">Celebrate Every Special Moment</h2>

            <div class="title-underline mx-auto"></div>

            <p class="text-muted mt-3">
                Discover the perfect fireworks to make every celebration bright,
                joyful and unforgettable
            </p>
        </div>

        <div class="row g-4">

            @php
                $occasions = [
                    [
                        'icon' => 'fa-star',
                        'color' => '#ff9800',
                        'bg' => 'rgba(255,152,0,0.10)',
                        'title' => 'Festival Celebrations',
                        'desc' => 'Bring extra brightness to festive gatherings with colourful crackers and spectacular fireworks.'
                    ],

                    [
                        'icon' => 'fa-gift',
                        'color' => '#e91e63',
                        'bg' => 'rgba(233,30,99,0.10)',
                        'title' => 'Birthday Moments',
                        'desc' => 'Turn birthdays into unforgettable memories with exciting crackers made for special moments.'
                    ],

                    [
                        'icon' => 'fa-heart',
                        'color' => '#9c27b0',
                        'bg' => 'rgba(156,39,176,0.10)',
                        'title' => 'Wedding Events',
                        'desc' => 'Add a magical touch to weddings with elegant fireworks and celebration-ready combos.'
                    ],

                    [
                        'icon' => 'fa-star',
                        'color' => '#1976d2',
                        'bg' => 'rgba(25,118,210,0.10)',
                        'title' => 'Grand Gatherings',
                        'desc' => 'Make family functions and special gatherings more exciting with vibrant fireworks.'
                    ],

                    [
                        'icon' => 'fa-moon',
                        'color' => '#43a047',
                        'bg' => 'rgba(67,160,71,0.10)',
                        'title' => 'Traditional Functions',
                        'desc' => 'Celebrate meaningful traditions and auspicious occasions with a beautiful range of crackers.'
                    ],

                    [
                        'icon' => 'fa-trophy',
                        'color' => '#f4511e',
                        'bg' => 'rgba(244,81,30,0.10)',
                        'title' => 'Victory Celebrations',
                        'desc' => 'Celebrate achievements, success and memorable milestones with an energetic burst of joy.'
                    ],
                ];
            @endphp

            @foreach($occasions as $occ)

                <div class="col-6 col-md-4 col-lg-2">

                    <a href="{{ route('front.products') }}" class="text-decoration-none">

                        <div class="text-center p-4 rounded-4 h-100 occasion-card" style="
                                                                                background: {{ $occ['bg'] }};
                                                                                border: 2px solid {{ $occ['color'] }}22;
                                                                                transition: transform 0.3s ease, box-shadow 0.3s ease;
                                                                             ">

                            <!-- Occasion Icon -->
                            <div class="mb-3" style="
                                                                                    width: 64px;
                                                                                    height: 64px;
                                                                                    background: {{ $occ['bg'] }};
                                                                                    border-radius: 50%;
                                                                                    display: flex;
                                                                                    align-items: center;
                                                                                    justify-content: center;
                                                                                    margin: 0 auto;
                                                                                    border: 2px solid {{ $occ['color'] }}44;
                                                                                 ">

                                <i class="fas {{ $occ['icon'] }} fa-2x" style="color: {{ $occ['color'] }};">
                                </i>

                            </div>

                            <!-- Occasion Title -->
                            <h6 class="fw-bold mb-2" style="color: #1a2233;">
                                {{ $occ['title'] }}
                            </h6>

                            <!-- Occasion Description -->
                            <p class="text-muted mb-0" style="
                                                                                    font-size: 0.78rem;
                                                                                    line-height: 1.5;
                                                                               ">
                                {{ $occ['desc'] }}
                            </p>

                        </div>

                    </a>

                </div>

            @endforeach

        </div>
    </div>

    <style>
        .occasion-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.10);
        }
    </style>

    <!-- ============================================================
                                         SECTION 2 : HOW IT WORKS
                                    ============================================================ -->
    <div class="py-5 my-3" style="background:linear-gradient(135deg,#f8fafc 0%,#fff4df 100%);border-radius:24px;">

        <div class="section-title-wrapper text-center mb-5">
            <h2 class="section-title">From Selection to Celebration</h2>

            <div class="title-underline mx-auto"></div>

            <p class="text-muted mt-3">
                Get your celebration-ready fireworks with a simple and hassle-free ordering experience
            </p>
        </div>

        <div class="row g-4 px-3 justify-content-center">

            @php
                $steps = [
                    [
                        'step' => '01',
                        'icon' => 'fa-th-large',
                        'color' => '#0d6b8a',
                        'title' => 'Explore Our Collection',
                        'desc' => 'Discover a wide selection of colourful crackers, family packs, gift boxes and celebration specials.'
                    ],

                    [
                        'step' => '02',
                        'icon' => 'fa-shopping-basket',
                        'color' => '#ff9900',
                        'title' => 'Choose Your Favourites',
                        'desc' => 'Pick the crackers you love, select the required quantity and add them to your shopping cart.'
                    ],

                    [
                        'step' => '03',
                        'icon' => 'fa-home',
                        'color' => '#e91e63',
                        'title' => 'Share Delivery Details',
                        'desc' => 'Enter your contact and delivery information so we can prepare your order for convenient delivery.'
                    ],

                    [
                        'step' => '04',
                        'icon' => 'fa-gift',
                        'color' => '#4caf50',
                        'title' => 'Get Ready to Celebrate',
                        'desc' => 'Your order is carefully prepared and dispatched so you can enjoy your special celebration with confidence.'
                    ],
                ];
            @endphp

            @foreach($steps as $i => $step)

                <div class="col-12 col-md-6 col-lg-3">

                    <div class="d-flex flex-column align-items-center text-center position-relative p-4">

                        <!-- Connector Line -->
                        @if($i < 3)

                            <div class="d-none d-lg-block position-absolute" style="
                                                                                            top:40px;
                                                                                            right:-30px;
                                                                                            width:60px;
                                                                                            height:3px;
                                                                                            background:linear-gradient(
                                                                                                90deg,
                                                                                                {{ $step['color'] }},
                                                                                                {{ $steps[$i + 1]['color'] }}
                                                                                            );
                                                                                            border-radius:2px;
                                                                                            z-index:1;
                                                                                         ">
                            </div>

                        @endif

                        <!-- Step Icon -->
                        <div style="
                                                                width:80px;
                                                                height:80px;
                                                                border-radius:50%;
                                                                background:{{ $step['color'] }};
                                                                display:flex;
                                                                align-items:center;
                                                                justify-content:center;
                                                                box-shadow:0 8px 25px {{ $step['color'] }}44;
                                                                margin-bottom:16px;
                                                                position:relative;
                                                                z-index:2;
                                                            ">

                            <i class="fas {{ $step['icon'] }} fa-2x text-white"></i>

                            <!-- Step Number -->
                            <span style="
                                                                    position:absolute;
                                                                    top:-8px;
                                                                    right:-8px;
                                                                    background:#fff;
                                                                    color:{{ $step['color'] }};
                                                                    font-size:0.7rem;
                                                                    font-weight:900;
                                                                    width:26px;
                                                                    height:26px;
                                                                    border-radius:50%;
                                                                    display:flex;
                                                                    align-items:center;
                                                                    justify-content:center;
                                                                    border:2px solid {{ $step['color'] }};
                                                                    box-shadow:0 2px 8px rgba(0,0,0,0.1);
                                                                ">
                                {{ $step['step'] }}
                            </span>

                        </div>

                        <!-- Step Title -->
                        <h6 class="fw-bold mb-2" style="
                                                                    color:#1a2233;
                                                                    font-size:1rem;
                                                                ">
                            {{ $step['title'] }}
                        </h6>

                        <!-- Step Description -->
                        <p class="text-muted mb-0" style="
                                                                    font-size:0.85rem;
                                                                    line-height:1.6;
                                                               ">
                            {{ $step['desc'] }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>
    </div>

    <!-- ============================================================
                                         SECTION 3 : WHY FAMILIES CHOOSE US
                                    ============================================================ -->
    <div class="py-5 my-5">

        <div class="section-title-wrapper text-center mb-5">
            <h2 class="section-title">The Difference You Can Feel</h2>

            <div class="title-underline mx-auto"></div>

            <p class="text-muted mt-3">
                Everything you need for a memorable celebration, from exciting crackers to dependable service
            </p>
        </div>

        <div class="row g-4">

            @php
                $reasons = [

                    [
                        'icon' => 'fa-certificate',
                        'color' => '#0d6b8a',
                        'title' => 'Quality You Can Trust',
                        'desc' => 'We carefully select our products from reliable manufacturers so you can enjoy consistent quality during every celebration.'
                    ],

                    [
                        'icon' => 'fa-tags',
                        'color' => '#ff9900',
                        'title' => 'Celebration-Friendly Prices',
                        'desc' => 'Enjoy attractive prices across our collection, with value-packed options for both small celebrations and large gatherings.'
                    ],

                    [
                        'icon' => 'fa-shipping-fast',
                        'color' => '#4caf50',
                        'title' => 'Convenient Delivery',
                        'desc' => 'Place your order online and we make the process simple from packing to dispatch, helping your celebration preparations stay stress-free.'
                    ],

                    [
                        'icon' => 'fa-gifts',
                        'color' => '#e91e63',
                        'title' => 'Special Celebration Packs',
                        'desc' => 'Choose from thoughtfully arranged combo packs and gift-ready selections created for families, friends and special occasions.'
                    ],

                    [
                        'icon' => 'fa-comments',
                        'color' => '#9c27b0',
                        'title' => 'Friendly Assistance',
                        'desc' => 'Need help choosing products or placing an order? Our team is ready to assist you with your questions and requirements.'
                    ],

                    [
                        'icon' => 'fa-leaf',
                        'color' => '#00a896',
                        'title' => 'Greener Choices',
                        'desc' => 'Explore available green-cracker options and make thoughtful choices while enjoying the excitement of your celebration.'
                    ],

                    [
                        'icon' => 'fa-credit-card',
                        'color' => '#ff5722',
                        'title' => 'Easy Payment Options',
                        'desc' => 'Complete your purchase conveniently with the payment methods available on our website for a smooth checkout experience.'
                    ],

                    [
                        'icon' => 'fa-users',
                        'color' => '#f44336',
                        'title' => 'Made for Every Celebration',
                        'desc' => 'Whether it is a family function, festival, wedding or special milestone, our collection is designed to add more joy to the occasion.'
                    ],

                ];
            @endphp

            @foreach($reasons as $r)

                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="p-4 rounded-4 h-100 why-card" style="
                                                background:#fff;
                                                border:1px solid #e8f0f5;
                                                transition:all 0.3s ease;
                                                box-shadow:0 2px 15px rgba(0,0,0,0.05);
                                             ">

                        <!-- Icon -->
                        <div style="
                                                width:54px;
                                                height:54px;
                                                background:{{ $r['color'] }}18;
                                                border-radius:14px;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                margin-bottom:16px;
                                            ">

                            <i class="fas {{ $r['icon'] }}" style="
                                                        font-size:1.4rem;
                                                        color:{{ $r['color'] }};
                                                   ">
                            </i>

                        </div>

                        <!-- Title -->
                        <h6 class="fw-bold mb-2" style="
                                                    color:#1a2233;
                                                    font-size:0.95rem;
                                                ">
                            {{ $r['title'] }}
                        </h6>

                        <!-- Description -->
                        <p class="text-muted mb-0" style="
                                                    font-size:0.82rem;
                                                    line-height:1.6;
                                               ">
                            {{ $r['desc'] }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>
    </div>

    <style>
        .why-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.10) !important;
        }
    </style>
    <!-- ============================================================
                                         SECTION 4 : CLIENT REVIEWS CAROUSEL
                                    ============================================================ -->
    <div class="py-5 my-3"
        style="background:linear-gradient(135deg,#0d6b8a 0%,#163b5c 100%);border-radius:24px;overflow:hidden;">

        <!-- Section Heading -->
        <div class="section-title-wrapper text-center mb-5">

            <h2 style="
                    font-size:2.2rem;
                    font-weight:900;
                    color:#fff;
                    margin-bottom:5px;
                    text-transform:uppercase;
                    letter-spacing:1px;
                ">
                Celebrations Loved by Our Customers
            </h2>

            <div class="title-underline mx-auto"></div>

            <p class="mt-3" style="color:rgba(255,255,255,0.75);">
                Hear what our customers have to share about their shopping experience
            </p>

        </div>


        @php
            $reviews = [

                [
                    'name' => 'Meena S.',
                    'city' => 'Chennai',
                    'stars' => 5,
                    'avatar' => 'MS',
                    'color' => '#ff9900',
                    'text' => 'The ordering process was very simple and the product selection was excellent. Everything was packed neatly and arrived ready for our family celebration.'
                ],

                [
                    'name' => 'Arun Prakash',
                    'city' => 'Coimbatore',
                    'stars' => 5,
                    'avatar' => 'AP',
                    'color' => '#e91e63',
                    'text' => 'I liked the variety of crackers available on the website. It was easy to compare products, select quantities and complete my order without any confusion.'
                ],

                [
                    'name' => 'Deepa R.',
                    'city' => 'Madurai',
                    'stars' => 5,
                    'avatar' => 'DR',
                    'color' => '#4caf50',
                    'text' => 'Bought a combination of crackers for our family function. The products were well packed and the overall shopping experience was smooth from start to finish.'
                ],

                [
                    'name' => 'Vignesh Kumar',
                    'city' => 'Salem',
                    'stars' => 4,
                    'avatar' => 'VK',
                    'color' => '#9c27b0',
                    'text' => 'Good collection with plenty of options for different budgets. I especially liked the combo selections because they made choosing products much easier.'
                ],

                [
                    'name' => 'Nandhini M.',
                    'city' => 'Trichy',
                    'stars' => 5,
                    'avatar' => 'NM',
                    'color' => '#00bcd4',
                    'text' => 'The website is clean and easy to navigate. I found the products I was looking for quickly and the checkout process was straightforward.'
                ],

                [
                    'name' => 'Karthik R.',
                    'city' => 'Krishnagiri',
                    'stars' => 5,
                    'avatar' => 'KR',
                    'color' => '#ff5722',
                    'text' => 'A convenient way to prepare for celebrations. The product details were easy to understand and the overall experience was comfortable and hassle-free.'
                ],

            ];

            // Split reviews into slides of 3
            $slides = array_chunk($reviews, 3);
        @endphp


        <!-- Reviews Carousel -->
        <div id="reviewsCarousel" class="carousel slide px-3 px-md-4" data-bs-ride="carousel" data-bs-interval="4500">


            <!-- Carousel Indicators -->
            <div class="carousel-indicators" style="bottom:-10px;">

                @foreach($slides as $idx => $slide)

                    <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="{{ $idx }}"
                        class="{{ $idx === 0 ? 'active' : '' }}" style="
                                width:10px;
                                height:10px;
                                border-radius:50%;
                                background:{{ $idx === 0 ? '#ffcc00' : 'rgba(255,255,255,0.4)' }};
                                border:none;
                                margin:0 5px;
                            ">
                    </button>

                @endforeach

            </div>


            <!-- Carousel Slides -->
            <div class="carousel-inner pb-5">

                @foreach($slides as $idx => $slide)

                    <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">

                        <div class="row g-4">

                            @foreach($slide as $rev)

                                <div class="col-12 col-md-4">

                                    <div class="p-4 rounded-4 h-100" style="
                                                    background:rgba(255,255,255,0.09);
                                                    backdrop-filter:blur(10px);
                                                    border:1px solid rgba(255,255,255,0.18);
                                                    min-height:250px;
                                                ">

                                        <!-- Rating -->
                                        <div class="mb-3">

                                            @for($s = 1; $s <= 5; $s++)

                                                <i class="fas fa-star" style="
                                                                    color:{{ $s <= $rev['stars'] ? '#ffcc00' : 'rgba(255,255,255,0.2)' }};
                                                                    font-size:0.88rem;
                                                                ">
                                                </i>

                                            @endfor

                                        </div>


                                        <!-- Review -->
                                        <p style="
                                                        color:rgba(255,255,255,0.88);
                                                        font-size:0.88rem;
                                                        line-height:1.7;
                                                        margin-bottom:20px;
                                                    ">
                                            "{{ $rev['text'] }}"
                                        </p>


                                        <!-- Customer Details -->
                                        <div class="d-flex align-items-center gap-3 mt-auto">

                                            <!-- Avatar -->
                                            <div style="
                                                            width:44px;
                                                            height:44px;
                                                            border-radius:50%;
                                                            background:{{ $rev['color'] }};
                                                            display:flex;
                                                            align-items:center;
                                                            justify-content:center;
                                                            font-weight:900;
                                                            color:#fff;
                                                            font-size:0.82rem;
                                                            flex-shrink:0;
                                                        ">
                                                {{ $rev['avatar'] }}
                                            </div>


                                            <!-- Name & Location -->
                                            <div>

                                                <div style="
                                                                color:#fff;
                                                                font-weight:700;
                                                                font-size:0.88rem;
                                                            ">
                                                    {{ $rev['name'] }}
                                                </div>

                                                <div style="
                                                                color:rgba(255,255,255,0.5);
                                                                font-size:0.75rem;
                                                            ">

                                                    <i class="fas fa-map-marker-alt me-1"></i>

                                                    {{ $rev['city'] }}, Tamil Nadu

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>


            <!-- Previous Button -->
            <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev"
                style="
                    width:44px;
                    height:44px;
                    background:rgba(255,255,255,0.15);
                    border-radius:50%;
                    top:50%;
                    transform:translateY(-50%);
                    left:6px;
                    border:1px solid rgba(255,255,255,0.25);
                ">

                <i class="fas fa-chevron-left" style="
                        color:#fff;
                        font-size:14px;
                    ">
                </i>

                <span class="visually-hidden">
                    Previous
                </span>

            </button>


            <!-- Next Button -->
            <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next"
                style="
                    width:44px;
                    height:44px;
                    background:rgba(255,255,255,0.15);
                    border-radius:50%;
                    top:50%;
                    transform:translateY(-50%);
                    right:6px;
                    border:1px solid rgba(255,255,255,0.25);
                ">

                <i class="fas fa-chevron-right" style="
                        color:#fff;
                        font-size:14px;
                    ">
                </i>

                <span class="visually-hidden">
                    Next
                </span>

            </button>

        </div>


        <!-- Experience Highlights -->
        <div class="row g-4 px-3 mt-5 text-center">

            <div class="col-4">

                <div style="
                        color:#ffcc00;
                        font-size:2.2rem;
                        font-weight:900;
                        line-height:1;
                    ">
                    Wide
                </div>

                <div style="
                        color:rgba(255,255,255,0.7);
                        font-size:0.85rem;
                    ">
                    Product Selection
                </div>

            </div>


            <div class="col-4">

                <div style="
                        color:#ffcc00;
                        font-size:2.2rem;
                        font-weight:900;
                        line-height:1;
                    ">
                    Easy
                </div>

                <div style="
                        color:rgba(255,255,255,0.7);
                        font-size:0.85rem;
                    ">
                    Online Ordering
                </div>

            </div>


            <div class="col-4">

                <div style="
                        color:#ffcc00;
                        font-size:2.2rem;
                        font-weight:900;
                        line-height:1;
                    ">
                    Careful
                </div>

                <div style="
                        color:rgba(255,255,255,0.7);
                        font-size:0.85rem;
                    ">
                    Product Packing
                </div>

            </div>

        </div>

    </div>

    <div class="text-center py-5 my-4"
        style="background: linear-gradient(135deg, #0d6b8a 0%, #1a8ab0 100%); border-radius: 20px; box-shadow: 0 10px 40px rgba(13,107,138,0.2);">
        <i class="fas fa-fire fa-3x mb-3" style="color:#ff9900;"></i>
        <h3 class="fw-bold text-white mb-2">Explore Our Full Product Range</h3>
        <p class="text-white mb-4" style="opacity:0.85;">Browse all categories, search by name or code, and add directly to
            your cart.</p>
        <a href="{{ route('front.products') }}" class="btn btn-lg rounded-pill px-5 fw-bold"
            style="background: linear-gradient(135deg,#ff9900,#ff3b3b); color:#fff; box-shadow: 0 4px 20px rgba(255,153,0,0.4); font-size:1.1rem;">
            <i class="fas fa-shopping-bag me-2"></i> View All Products
        </a>
    </div>







    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Category Search Logic
                const catSearchInput = document.getElementById('categorySearchInput');
                const catClearBtn = document.getElementById('clearCategorySearchBtn');
                const catCards = document.querySelectorAll('.category-card');
                const catNoMsg = document.getElementById('noCategoriesMsg');

                if (catSearchInput && catCards.length > 0) {
                    catSearchInput.addEventListener('keyup', function () {
                        const term = this.value.toLowerCase().trim();
                        let hasVisible = false;

                        catClearBtn.style.display = term.length > 0 ? 'block' : 'none';

                        catCards.forEach(card => {
                            const name = card.querySelector('.category-card-name').textContent.toLowerCase();
                            if (name.includes(term)) {
                                card.style.display = 'block';
                                hasVisible = true;
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        if (catNoMsg) {
                            catNoMsg.style.display = hasVisible ? 'none' : 'block';
                        }
                    });

                    if (catClearBtn) {
                        catClearBtn.addEventListener('click', function () {
                            catSearchInput.value = '';
                            catSearchInput.dispatchEvent(new Event('keyup'));
                            catSearchInput.focus();
                        });
                    }
                }
            });
        </script>
    @endpush
@endsection