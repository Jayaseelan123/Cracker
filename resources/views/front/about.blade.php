@extends('layouts.app')

@section('title', 'About Us - Crackers Time')
@section('hero_title', 'About Crackers Time')
@section('hero_subtitle', 'Trusted Fireworks & Crackers Supplier Since 2016')

@section('content')

<style>
    /* ── GLOBAL ── */
    .about-section { padding: 60px 0; }
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
    .title-bar.left { margin: 0 0 25px; }

    /* ── INTRO CARD ── */
    .intro-card {
        background: #fff;
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,.08);
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
        box-shadow: 0 12px 35px rgba(0,0,0,.15);
    }

    /* ── STATS ── */
    .stats-strip {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 50px 0;
    }
    .stat-box { text-align: center; color: #fff; }
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
        background: rgba(255,255,255,.15);
        height: 60px;
        margin: auto;
    }

    /* ── WHY CHOOSE US CARDS ── */
    .why-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px 25px;
        box-shadow: 0 6px 25px rgba(0,0,0,.07);
        transition: transform .35s ease, box-shadow .35s ease;
        height: 100%;
        border-bottom: 4px solid transparent;
    }
    .why-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0,0,0,.13);
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
    .why-card h5 { font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
    .why-card p  { color: #666; font-size: .93rem; margin: 0; }

    /* ── TIMELINE ── */
    .timeline { position: relative; padding-left: 40px; }
    .timeline::before {
        content: '';
        position: absolute;
        left: 14px;
        top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #ff9900, #ff6600);
        border-radius: 3px;
    }
    .tl-item { position: relative; margin-bottom: 36px; }
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
    .tl-item h6 { font-weight: 700; color: #1a1a2e; margin: 4px 0 6px; font-size: 1rem; }
    .tl-item p  { color: #666; font-size: .9rem; margin: 0; line-height: 1.7; }

    /* ── VALUES ── */
    .value-chip {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        background: #fff;
        border-radius: 14px;
        padding: 22px 20px;
        box-shadow: 0 4px 18px rgba(0,0,0,.06);
        margin-bottom: 18px;
        transition: transform .3s;
    }
    .value-chip:hover { transform: translateX(6px); }
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
    .value-chip h6 { font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
    .value-chip p  { color: #666; font-size: .88rem; margin: 0; }

    /* ── PROMISE BANNER ── */
    .promise-banner {
        background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%);
        border-radius: 20px;
        padding: 50px 40px;
        color: #fff;
        text-align: center;
    }
    .promise-banner h3 { font-size: 1.9rem; font-weight: 800; margin-bottom: 14px; }
    .promise-banner p  { font-size: 1.05rem; opacity: .92; max-width: 600px; margin: 0 auto 28px; }
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
        box-shadow: 0 8px 25px rgba(0,0,0,.2);
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
    .contact-strip .ci:last-child { margin-bottom: 0; }
    .contact-strip .ci .ci-icon {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #ff9900, #ff6600);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 16px; flex-shrink: 0;
    }
    .contact-strip .ci p { margin: 0; color: #555; font-size: .92rem; }
    .contact-strip .ci span { font-weight: 700; color: #1a1a2e; display: block; }

    /* ── ANIMATIONS ── */
    .animate {
        opacity: 0;
        transform: translateY(35px);
        transition: opacity .75s ease, transform .75s ease;
    }
    .animate.show { opacity: 1; transform: translateY(0); }
    .animate-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: opacity .75s ease, transform .75s ease;
    }
    .animate-left.show { opacity: 1; transform: translateX(0); }
    .animate-right {
        opacity: 0;
        transform: translateX(40px);
        transition: opacity .75s ease, transform .75s ease;
    }
    .animate-right.show { opacity: 1; transform: translateX(0); }

    .delay-1 { transition-delay: .1s; }
    .delay-2 { transition-delay: .25s; }
    .delay-3 { transition-delay: .4s; }
    .delay-4 { transition-delay: .55s; }
    .delay-5 { transition-delay: .7s; }
    .delay-6 { transition-delay: .85s; }
</style>

<!-- ═══════════════════════════════════════
     SECTION 1 — INTRO / STORY
════════════════════════════════════════ -->
<section class="about-section pb-0">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Text -->
            <div class="col-lg-6 animate-left">
                <span class="section-badge">Our Story</span>
                <h2 class="section-title">Welcome to<br>Crackers Time! 🎉</h2>
                <div class="title-bar left"></div>
                <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                    Founded in <strong>2016</strong> in the heart of Sivakasi — the fireworks capital of India —
                    <strong>Crackers Time</strong> was born from a simple dream: to bring safe, stunning, and
                    affordable crackers to every home across the country.
                </p>
                <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                    Over the past <strong>8+ years</strong>, we have served lakhs of happy customers, delivering
                    joy, colour, and excitement on Diwali, weddings, new year celebrations, and every festive
                    occasion in between. We source directly from licensed manufacturers, guaranteeing
                    <strong>100% authentic, BIS-certified products</strong> at prices that beat the market.
                </p>
                <p style="color:#555; line-height:1.9; font-size:1.05rem;">
                    Whether you're planning a grand wedding display or a cosy family Diwali, our expert team
                    curates the perfect package for you — with doorstep delivery anywhere in India.
                </p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="{{ route('home') }}" class="btn btn-warning fw-bold px-4 py-2 rounded-pill">
                        🛒 Shop Now
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-dark fw-bold px-4 py-2 rounded-pill">
                        📞 Contact Us
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="col-lg-6 animate-right">
                <div class="intro-img-wrap">
                    <img
                        src="https://images.unsplash.com/photo-1514912885225-5b6b4f5e5f78?w=800&q=80"
                        alt="Crackers Time fireworks display"
                    >
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

            <div class="col-6 col-md-3 animate delay-1">
                <div class="stat-box">
                    <div class="number">8+</div>
                    <div class="label">Years of Experience</div>
                </div>
            </div>

            <div class="col-6 col-md-3 animate delay-2">
                <div class="stat-box">
                    <div class="number">50K+</div>
                    <div class="label">Happy Customers</div>
                </div>
            </div>

            <div class="col-6 col-md-3 animate delay-3">
                <div class="stat-box">
                    <div class="number">500+</div>
                    <div class="label">Products Available</div>
                </div>
            </div>

            <div class="col-6 col-md-3 animate delay-4">
                <div class="stat-box">
                    <div class="number">28</div>
                    <div class="label">States Delivered</div>
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
        <div class="text-center mb-5 animate">
            <span class="section-badge">Why Us</span>
            <h2 class="section-title">Why Choose Crackers Time? ✨</h2>
            <div class="title-bar"></div>
            <p class="text-muted mx-auto" style="max-width:550px;">
                We're not just a cracker shop — we're your celebration partner. Here's what sets us apart.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-sm-6 col-lg-4 animate delay-1">
                <div class="why-card">
                    <div class="why-icon" style="background:#fff3e0;">🏆</div>
                    <h5>Licensed & Certified</h5>
                    <p>All our products are BIS-certified and sourced from licensed manufacturers in Sivakasi, ensuring 100% safety for your family.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 animate delay-2">
                <div class="why-card">
                    <div class="why-icon" style="background:#e8f5e9;">🚚</div>
                    <h5>Pan-India Delivery</h5>
                    <p>We deliver across all 28 states and 8 union territories of India. Quick dispatch with real-time order tracking.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 animate delay-3">
                <div class="why-card">
                    <div class="why-icon" style="background:#fce4ec;">💰</div>
                    <h5>Best Prices Guaranteed</h5>
                    <p>Direct factory sourcing means no middlemen — you get the best market price with regular seasonal discounts.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 animate delay-4">
                <div class="why-card">
                    <div class="why-icon" style="background:#e3f2fd;">🎨</div>
                    <h5>Huge Variety</h5>
                    <p>From sparklers and flower pots to aerial shells and grand displays — 500+ products for every budget and occasion.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 animate delay-5">
                <div class="why-card">
                    <div class="why-icon" style="background:#f3e5f5;">📞</div>
                    <h5>24/7 Customer Support</h5>
                    <p>Our dedicated support team is available round the clock via phone, WhatsApp, and email to assist you anytime.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 animate delay-6">
                <div class="why-card">
                    <div class="why-icon" style="background:#e0f7fa;">🌿</div>
                    <h5>Eco-Friendly Options</h5>
                    <p>We proudly stock a curated range of green crackers approved by CSIR-NEERI to help reduce pollution this festive season.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     SECTION 4 — OUR JOURNEY (TIMELINE)
════════════════════════════════════════ -->
<section class="about-section" style="background:#f8f9fa; border-radius: 24px; margin: 0 20px;">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- Timeline -->
            <div class="col-lg-6 animate-left">
                <span class="section-badge">Our Journey</span>
                <h2 class="section-title">A Decade of<br>Celebrations 🎆</h2>
                <div class="title-bar left"></div>

                <div class="timeline mt-4">
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <span class="tl-year">2016</span>
                        <h6>Crackers Time Founded</h6>
                        <p>Started as a small retail shop in Sivakasi with a passion for quality fireworks and a goal to serve local customers.</p>
                    </div>
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <span class="tl-year">2018</span>
                        <h6>First Online Presence</h6>
                        <p>Launched our first website and began accepting online orders, reaching customers across Tamil Nadu.</p>
                    </div>
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <span class="tl-year">2020</span>
                        <h6>Pan-India Shipping</h6>
                        <p>Partnered with leading logistics providers to offer reliable pan-India delivery, serving 10,000+ customers.</p>
                    </div>
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <span class="tl-year">2022</span>
                        <h6>Eco-Friendly Range Launch</h6>
                        <p>Introduced our CSIR-NEERI approved green crackers range, committing to a cleaner, greener festive season.</p>
                    </div>
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <span class="tl-year">2024</span>
                        <h6>50,000+ Happy Customers</h6>
                        <p>Crossed the milestone of 50,000+ satisfied customers and launched our revamped online store with faster checkout.</p>
                    </div>
                </div>
            </div>

            <!-- Values -->
            <div class="col-lg-6 animate-right">
                <span class="section-badge">Our Values</span>
                <h2 class="section-title">What We Stand For 💛</h2>
                <div class="title-bar left"></div>

                <div class="value-chip mt-4">
                    <div class="vc-icon">🛡️</div>
                    <div>
                        <h6>Safety First</h6>
                        <p>Every product we sell meets strict safety standards. We never compromise on the safety of our customers and their families.</p>
                    </div>
                </div>

                <div class="value-chip">
                    <div class="vc-icon">🤝</div>
                    <div>
                        <h6>Trust & Transparency</h6>
                        <p>We display honest pricing, clear product descriptions, and maintain complete transparency in every transaction.</p>
                    </div>
                </div>

                <div class="value-chip">
                    <div class="vc-icon">🌟</div>
                    <div>
                        <h6>Quality Without Compromise</h6>
                        <p>We personally inspect and test products before listing them on our platform, so you always get the best.</p>
                    </div>
                </div>

                <div class="value-chip">
                    <div class="vc-icon">💚</div>
                    <div>
                        <h6>Environmental Responsibility</h6>
                        <p>We actively promote eco-friendly crackers and responsible celebration practices to protect our environment.</p>
                    </div>
                </div>

                <div class="value-chip">
                    <div class="vc-icon">❤️</div>
                    <div>
                        <h6>Customer Happiness</h6>
                        <p>Your smile is our reward. We go the extra mile to ensure every order is delivered perfectly and on time.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     SECTION 5 — CONTACT INFO
════════════════════════════════════════ -->
<section class="about-section pb-2">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6 animate-left">
                <span class="section-badge">Get In Touch</span>
                <h2 class="section-title">We're Here<br>to Help You 📍</h2>
                <div class="title-bar left"></div>
                <p style="color:#666; line-height:1.9;">
                    Have questions about our products, bulk orders, or delivery? Our friendly team is just a
                    call or message away. Reach out anytime!
                </p>

                <div class="contact-strip mt-4">
                    <div class="ci">
                        <div class="ci-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <p><span>Phone / WhatsApp</span>+91 94888 64547</p>
                        </div>
                    </div>
                    <div class="ci">
                        <div class="ci-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <p><span>Email</span>crackerstime.com@gmail.com</p>
                        </div>
                    </div>
                    <div class="ci">
                        <div class="ci-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <p><span>Address</span>Door No 2/554/C3, Southside School Near, Sivakasi to Sattur Main Road, Mettamalai, Sivakasi – 626 203</p>
                        </div>
                    </div>
                    <div class="ci">
                        <div class="ci-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <p><span>Business Hours</span>Mon – Sat: 9:00 AM – 8:00 PM | Sun: 10:00 AM – 6:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promise Banner -->
            <div class="col-lg-6 animate-right">
                <div class="promise-banner">
                    <div style="font-size:60px; margin-bottom:16px;">🎆</div>
                    <h3>Our Promise to You</h3>
                    <p>
                        Premium quality crackers, unbeatable prices, safe delivery, and memories that last a lifetime.
                        That's the <strong>Crackers Time</strong> guarantee — every single time.
                    </p>
                    <a href="{{ route('home') }}" class="btn-light">🛒 Explore Products</a>

                    <div class="row g-3 mt-4">
                        <div class="col-4">
                            <div style="background:rgba(255,255,255,.18); border-radius:12px; padding:16px 10px;">
                                <div style="font-size:26px;">✅</div>
                                <div style="font-size:.8rem; margin-top:6px;">Quality<br>Assured</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div style="background:rgba(255,255,255,.18); border-radius:12px; padding:16px 10px;">
                                <div style="font-size:26px;">🔒</div>
                                <div style="font-size:.8rem; margin-top:6px;">Secure<br>Payments</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div style="background:rgba(255,255,255,.18); border-radius:12px; padding:16px 10px;">
                                <div style="font-size:26px;">🚀</div>
                                <div style="font-size:.8rem; margin-top:6px;">Fast<br>Delivery</div>
                            </div>
                        </div>
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
