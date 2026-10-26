@extends('layouts.app')

@section('title', 'About Us | Kasthuri Crackers - Sivakasi Crackers Shop')
@section('meta_description', 'Learn about Kasthuri Crackers, a trusted Sivakasi crackers shop. Discover our story, quality standards and commitment to safe, affordable fireworks.')
@section('hero_title', 'About Kasthuripyro')
@section('hero_subtitle', 'Discover Our Complete Range of Fireworks')

@section('content')

    <style>
        /* ── GLOBAL ── */
        html,
        body {
            overflow-x: hidden;
        }

        .about-section {
            padding: 60px 0;
        }

        .section-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff9900, #ff6600);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 16px;
            border-radius: 30px;
            margin-bottom: 14px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        .title-bar {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #ff9900, #ff6600);
            border-radius: 4px;
            margin: 0 auto 25px;
        }

        .title-bar.left {
            margin: 0 0 25px;
        }

        /* ── INTRO CARD ── */
        .intro-card {
            background: #fff;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
            border-top: 5px solid #ff9900;
        }

        .intro-card p {
            font-size: 1.08rem;
            color: #555;
            line-height: 1.9;
        }

        .intro-img-wrap img {
            border-radius: 16px;
            width: 100%;
            height: 320px;
            object-fit: cover;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .15);
        }

        /* ── STATS ── */
        .stats-strip {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 50px 0;
        }

        .stat-box {
            text-align: center;
            color: #fff;
        }

        .stat-box .number {
            font-size: 2.8rem;
            font-weight: 900;
            color: #ff9900;
            line-height: 1;
        }

        .stat-box .label {
            font-size: 0.95rem;
            opacity: .8;
            margin-top: 6px;
        }

        .stat-divider {
            width: 1px;
            background: rgba(255, 255, 255, .15);
            height: 60px;
            margin: auto;
        }

        /* ── WHY CHOOSE US CARDS ── */
        .why-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px 25px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, .07);
            transition: transform .35s ease, box-shadow .35s ease;
            height: 100%;
            border-bottom: 4px solid transparent;
        }

        .why-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, .13);
            border-bottom-color: #ff9900;
        }

        .why-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .why-card h5 {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        .why-card p {
            color: #666;
            font-size: .93rem;
            margin: 0;
        }

        /* ── TIMELINE ── */
        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 14px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #ff9900, #ff6600);
            border-radius: 3px;
        }

        .tl-item {
            position: relative;
            margin-bottom: 36px;
        }

        .tl-dot {
            position: absolute;
            left: -33px;
            top: 4px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #ff9900;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #ff9900;
        }

        .tl-year {
            font-size: .78rem;
            font-weight: 700;
            color: #ff9900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .tl-item h6 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 4px 0 6px;
            font-size: 1rem;
        }

        .tl-item p {
            color: #666;
            font-size: .9rem;
            margin: 0;
            line-height: 1.7;
        }

        /* ── VALUES ── */
        .value-chip {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            background: #fff;
            border-radius: 14px;
            padding: 22px 20px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
            margin-bottom: 18px;
            transition: transform .3s;
        }

        .value-chip:hover {
            transform: translateX(6px);
        }

        .value-chip .vc-icon {
            font-size: 28px;
            min-width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ffefba, #ffe066);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .value-chip h6 {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .value-chip p {
            color: #666;
            font-size: .88rem;
            margin: 0;
        }

        /* ── PROMISE BANNER ── */
        .promise-banner {
            background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%);
            border-radius: 20px;
            padding: 50px 40px;
            color: #fff;
            text-align: center;
        }

        .promise-banner h3 {
            font-size: 1.9rem;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .promise-banner p {
            font-size: 1.05rem;
            opacity: .92;
            max-width: 600px;
            margin: 0 auto 28px;
        }

        .promise-banner .btn-light {
            background: #fff;
            color: #ff6600;
            font-weight: 700;
            border-radius: 30px;
            padding: 12px 36px;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: transform .25s, box-shadow .25s;
        }

        .promise-banner .btn-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, .2);
        }

        /* ── CONTACT STRIP ── */
        .contact-strip {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 30px;
        }

        .contact-strip .ci {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .contact-strip .ci:last-child {
            margin-bottom: 0;
        }

        .contact-strip .ci .ci-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ff9900, #ff6600);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            flex-shrink: 0;
        }

        .contact-strip .ci p {
            margin: 0;
            color: #555;
            font-size: .92rem;
        }

        .contact-strip .ci span {
            font-weight: 700;
            color: #1a1a2e;
            display: block;
        }

        /* ── ANIMATIONS ── */
        .animate {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity .75s ease, transform .75s ease;
        }

        .animate.show {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity .75s ease, transform .75s ease;
        }

        .animate-left.show {
            opacity: 1;
            transform: translateX(0);
        }

        .animate-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity .75s ease, transform .75s ease;
        }

        .animate-right.show {
            opacity: 1;
            transform: translateX(0);
        }

        .delay-1 {
            transition-delay: .1s;
        }

        .delay-2 {
            transition-delay: .25s;
        }

        .delay-3 {
            transition-delay: .4s;
        }

        .delay-4 {
            transition-delay: .55s;
        }

        .delay-5 {
            transition-delay: .7s;
        }

        .delay-6 {
            transition-delay: .85s;
        }
    </style>

    <!-- ═══════════════════════════════════════
                             SECTION 1 — INTRO / STORY
                        ════════════════════════════════════════ -->
    <section class="about-section pb-0">

        <div class="container">

            <div class="row align-items-center g-5">

                <!-- Text -->
                <div class="col-lg-6 animate-left">

                    <span class="section-badge">About Kasthuripyro</span>

                    <h2 class="section-title">
                        Bringing More Sparkle<br>
                        to Every Celebration! ✨
                    </h2>

                    <div class="title-bar left"></div>

                    <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                        Welcome to <strong>Kasthuripyro</strong>, your destination for a vibrant collection
                        of fireworks and celebration essentials. We are passionate about making every special
                        occasion brighter with carefully selected products, attractive choices, and a smooth
                        shopping experience.
                    </p>

                    <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                        From colourful crackers and sparkling favourites to thoughtfully arranged combo packs,
                        our collection is designed for families, friends, celebrations, and memorable gatherings.
                        We focus on offering products from reliable sources while making it simple for you to
                        discover the right options for your occasion.
                    </p>

                    <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                        Whether you're getting ready for <strong>Diwali, a wedding, a family function,
                            a birthday, or another special celebration</strong>, Kasthuripyro is here to help
                        you add an extra touch of excitement to the moment.
                    </p>

                    <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                        Browse our collection, choose your favourites, and get ready to create
                        bright memories with the people who matter most.
                    </p>

                    <div class="d-flex gap-3 mt-4 flex-wrap">

                        <a href="{{ route('front.products') }}" class="btn btn-warning fw-bold px-4 py-2 rounded-pill">
                            🛒 Explore Products
                        </a>

                        <a href="{{ route('contact') }}" class="btn btn-outline-dark fw-bold px-4 py-2 rounded-pill">
                            📞 Get in Touch
                        </a>

                    </div>

                </div>


                <!-- Image -->
                <div class="col-lg-6 animate-right">

                    <div class="intro-img-wrap">

                        <img src="{{ asset('images/hero-poster.png') }}" alt="Kasthuripyro fireworks and celebration collection">

                    </div>

                </div>

            </div>

        </div>

    </section>
    <!-- ═══════════════════════════════════════
                             SECTION 2 — STATS STRIP
                        ════════════════════════════════════════ -->
    <section class="stats-strip mt-5">

        <div class="container">

            <div class="row g-4 align-items-center text-center">

                <!-- Stat 1 -->
                <div class="col-6 col-md-3 animate delay-1">

                    <div class="stat-box">

                        <div class="number">
                            Quality
                        </div>

                        <div class="label">
                            Carefully Selected Products
                        </div>

                    </div>

                </div>


                <!-- Stat 2 -->
                <div class="col-6 col-md-3 animate delay-2">

                    <div class="stat-box">

                        <div class="number">
                            Wide
                        </div>

                        <div class="label">
                            Range of Celebration Choices
                        </div>

                    </div>

                </div>


                <!-- Stat 3 -->
                <div class="col-6 col-md-3 animate delay-3">

                    <div class="stat-box">

                        <div class="number">
                            Easy
                        </div>

                        <div class="label">
                            Online Shopping Experience
                        </div>

                    </div>

                </div>


                <!-- Stat 4 -->
                <div class="col-6 col-md-3 animate delay-4">

                    <div class="stat-box">

                        <div class="number">
                            Care
                        </div>

                        <div class="label">
                            Customer-Focused Service
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ═══════════════════════════════════════
                             SECTION 3 — WHY CHOOSE US
                        ════════════════════════════════════════ -->
    <section class="about-section">

        <div class="container">

            <!-- Section Heading -->
            <div class="text-center mb-5 animate">

                <span class="section-badge">
                    Why Kasthuripyro
                </span>

                <h2 class="section-title">
                    Made for Moments That Matter ✨
                </h2>

                <div class="title-bar"></div>

                <p class="text-muted mx-auto" style="max-width:550px;">
                    From choosing your favourite crackers to getting ready for the celebration,
                    we aim to make every step simple, convenient and enjoyable.
                </p>

            </div>


            <!-- Why Choose Us -->
            <div class="row g-4">

                <!-- Card 1 -->
                <div class="col-sm-6 col-lg-4 animate delay-1">

                    <div class="why-card">

                        <div class="why-icon" style="background:#fff3e0;">
                            ⭐
                        </div>

                        <h5>
                            Carefully Chosen Collection
                        </h5>

                        <p>
                            Explore a thoughtfully selected range of crackers and celebration
                            products suitable for family gatherings, festivals and special occasions.
                        </p>

                    </div>

                </div>


                <!-- Card 2 -->
                <div class="col-sm-6 col-lg-4 animate delay-2">

                    <div class="why-card">

                        <div class="why-icon" style="background:#e8f5e9;">
                            📦
                        </div>

                        <h5>
                            Neat & Careful Packing
                        </h5>

                        <p>
                            We take care while preparing your order so your selected products
                            are organised and packed properly before dispatch.
                        </p>

                    </div>

                </div>


                <!-- Card 3 -->
                <div class="col-sm-6 col-lg-4 animate delay-3">

                    <div class="why-card">

                        <div class="why-icon" style="background:#fce4ec;">
                            💰
                        </div>

                        <h5>
                            Value for Your Celebration
                        </h5>

                        <p>
                            Choose from different price ranges and convenient combinations,
                            making it easier to plan your celebration according to your budget.
                        </p>

                    </div>

                </div>


                <!-- Card 4 -->
                <div class="col-sm-6 col-lg-4 animate delay-4">

                    <div class="why-card">

                        <div class="why-icon" style="background:#e3f2fd;">
                            🎆
                        </div>

                        <h5>
                            Something for Every Occasion
                        </h5>

                        <p>
                            Whether it is Diwali, a wedding, birthday or family function,
                            discover products that can add more excitement to your special day.
                        </p>

                    </div>

                </div>


                <!-- Card 5 -->
                <div class="col-sm-6 col-lg-4 animate delay-5">

                    <div class="why-card">

                        <div class="why-icon" style="background:#f3e5f5;">
                            💬
                        </div>

                        <h5>
                            Helpful Customer Service
                        </h5>

                        <p>
                            Have a question about an order or product? Our team is available
                            to help you with your shopping and provide the information you need.
                        </p>

                    </div>

                </div>


                <!-- Card 6 -->
                <div class="col-sm-6 col-lg-4 animate delay-6">

                    <div class="why-card">

                        <div class="why-icon" style="background:#e0f7fa;">
                            🌿
                        </div>

                        <h5>
                            Responsible Choices
                        </h5>

                        <p>
                            We encourage thoughtful celebration and provide available
                            green-cracker options for customers looking for more responsible choices.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>
    <!-- ═══════════════════════════════════════
                             SECTION 4 — OUR JOURNEY (TIMELINE)
                        ════════════════════════════════════════ -->
    <section class="about-section" style="background:#f8f9fa; border-radius:24px; margin:0 20px;">

        <div class="container">

            <div class="row g-5 align-items-start">

                <!-- Our Journey -->
                <div class="col-lg-6 animate-left">

                    <span class="section-badge">
                        Our Journey
                    </span>

                    <h2 class="section-title">
                        Growing With<br>
                        Every Celebration 🎆
                    </h2>

                    <div class="title-bar left"></div>


                    <div class="timeline mt-4">

                        <!-- Journey 1 -->
                        <div class="tl-item">

                            <div class="tl-dot"></div>

                            <span class="tl-year">
                                Getting Started
                            </span>

                            <h6>
                                The Beginning of Kasthuripyro
                            </h6>

                            <p>
                                Kasthuripyro began with a simple idea — make it easier for families
                                to find quality fireworks and celebration products for their special moments.
                            </p>

                        </div>


                        <!-- Journey 2 -->
                        <div class="tl-item">

                            <div class="tl-dot"></div>

                            <span class="tl-year">
                                Growing Collection
                            </span>

                            <h6>
                                Expanding Our Product Range
                            </h6>

                            <p>
                                As customer needs grew, we expanded our collection with different
                                varieties and options suitable for festivals, family functions and celebrations.
                            </p>

                        </div>


                        <!-- Journey 3 -->
                        <div class="tl-item">

                            <div class="tl-dot"></div>

                            <span class="tl-year">
                                Going Digital
                            </span>

                            <h6>
                                Bringing Shopping Online
                            </h6>

                            <p>
                                We introduced a convenient online shopping experience so customers
                                could explore products, choose their favourites and place orders with ease.
                            </p>

                        </div>


                        <!-- Journey 4 -->
                        <div class="tl-item">

                            <div class="tl-dot"></div>

                            <span class="tl-year">
                                Better Experience
                            </span>

                            <h6>
                                Improving Every Step
                            </h6>

                            <p>
                                We continued improving our product presentation, ordering process
                                and customer support to make celebration shopping simpler and more convenient.
                            </p>

                        </div>


                        <!-- Journey 5 -->
                        <div class="tl-item">

                            <div class="tl-dot"></div>

                            <span class="tl-year">
                                Today
                            </span>

                            <h6>
                                Ready for Your Next Celebration
                            </h6>

                            <p>
                                Today, Kasthuripyro continues to bring together a carefully selected
                                range of fireworks and celebration essentials for customers looking to create
                                memorable moments.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- Our Values -->
                <div class="col-lg-6 animate-right">

                    <span class="section-badge">
                        Our Values
                    </span>

                    <h2 class="section-title">
                        The Principles<br>
                        Behind Our Work 💛
                    </h2>

                    <div class="title-bar left"></div>


                    <!-- Value 1 -->
                    <div class="value-chip mt-4">

                        <div class="vc-icon">
                            🛡️
                        </div>

                        <div>

                            <h6>
                                Responsible Shopping
                            </h6>

                            <p>
                                We believe celebrations should be enjoyable and responsible,
                                so we encourage customers to choose products thoughtfully and follow
                                safe usage practices.
                            </p>

                        </div>

                    </div>


                    <!-- Value 2 -->
                    <div class="value-chip">

                        <div class="vc-icon">
                            🤝
                        </div>

                        <div>

                            <h6>
                                Honest Service
                            </h6>

                            <p>
                                Clear information and straightforward communication are important to us.
                                We aim to make every interaction simple and transparent.
                            </p>

                        </div>

                    </div>


                    <!-- Value 3 -->
                    <div class="value-chip">

                        <div class="vc-icon">
                            ✨
                        </div>

                        <div>

                            <h6>
                                Product Selection
                            </h6>

                            <p>
                                We continuously work to offer a varied collection so customers
                                can find suitable options for different celebrations, preferences and budgets.
                            </p>

                        </div>

                    </div>


                    <!-- Value 4 -->
                    <div class="value-chip">

                        <div class="vc-icon">
                            🌿
                        </div>

                        <div>

                            <h6>
                                Thoughtful Celebrations
                            </h6>

                            <p>
                                We support mindful celebration practices and highlight available
                                green-cracker choices for customers who want to make more conscious selections.
                            </p>

                        </div>

                    </div>


                    <!-- Value 5 -->
                    <div class="value-chip">

                        <div class="vc-icon">
                            ❤️
                        </div>

                        <div>

                            <h6>
                                Customer Experience
                            </h6>

                            <p>
                                From browsing products to completing an order, we focus on creating
                                a convenient experience that helps you prepare for your celebration with confidence.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add("show");
                    }
                });
            }, { threshold: 0.15 });

            document.querySelectorAll(".animate, .animate-left, .animate-right")
                .forEach(el => observer.observe(el));
        });
    </script>

@endsection