{{-- =====================================================
     COMMON FOOTER PARTIAL — CrackerTime
     Dynamically pulls from company_details table (id=1).
     All CSS + HTML in one place. No duplication needed.
====================================================== --}}

@php
    $company = \App\Models\CompanyDetail::first();
@endphp

<style>
    /* ================= FOOTER WRAPPER ================= */
    .site-footer {
        background: linear-gradient(135deg, #0a4f68 0%, #063647 100%);
        color: #e0e0e0;
        padding: 70px 0 0;
        font-family: 'Inter', Arial, sans-serif;
        margin-top: 60px;
        position: relative;
        overflow: hidden;
    }

    /* Orange gradient top accent bar */
    .site-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #ff9900, #ff3b3b);
    }

    /* ================= 3-COLUMN GRID ================= */
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 30px;
        display: grid;
        grid-template-columns: 2fr 1fr 2fr;
        gap: 50px;
        position: relative;
        z-index: 2;
    }

    /* ================= LOGO ================= */
    .footer-logo {
        font-size: 32px;
        font-weight: 900;
        display: inline-block;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #ff9900, #ff3b3b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 0.5px;
    }

    .footer-logo-img {
        max-height: 70px;
        max-width: 200px;
        object-fit: contain;
        margin-bottom: 16px;
        display: block;
        /* Slight background so any logo color is visible on dark footer */
        background: rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        padding: 6px 10px;
    }


    /* ================= TAGLINE ================= */
    .footer-tagline {
        line-height: 1.8;
        opacity: 0.85;
        color: #b0b0c0;
        margin-bottom: 0;
        font-size: 14px;
        max-width: 360px;
    }

    /* ================= SECTION HEADINGS ================= */
    .site-footer h4 {
        margin-bottom: 28px;
        font-size: 15px;
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }

    /* Orange underline accent */
    .site-footer h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 36px;
        height: 2px;
        background: #ff9900;
        border-radius: 2px;
    }

    /* ================= LATEST POSTS ================= */
    .latest-posts {
        margin-top: 28px;
    }

    .latest-posts p {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .latest-posts a {
        color: #b0b0c0 !important;
        text-decoration: none !important;
        font-size: 14px;
        transition: color 0.25s ease, padding-left 0.25s ease;
        display: inline-block;
    }

    .latest-posts a:hover {
        color: #ff9900 !important;
        padding-left: 5px;
    }

    /* ================= QUICK LINKS ================= */
    .footer-links ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: #b0b0c0;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.25s ease, padding-left 0.25s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #ff9900;
        padding-left: 5px;
    }

    /* ================= CONTACT INFO ================= */
    .footer-contact p {
        margin-bottom: 14px;
        line-height: 1.6;
        color: #b0b0c0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 14px;
    }

    .footer-contact i {
        color: #ff9900;
        font-size: 16px;
        margin-top: 3px;
        flex-shrink: 0;
        width: 18px;
        text-align: center;
    }

    /* ================= WHATSAPP BUTTON ================= */
    .footer-whatsapp-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25d366;
        color: #fff !important;
        text-decoration: none !important;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 6px;
        transition: background 0.25s ease, transform 0.25s ease;
    }

    .footer-whatsapp-btn:hover {
        background: #1ebe5d;
        transform: translateY(-2px);
        color: #fff !important;
    }

    /* ================= DIVIDER ================= */
    .footer-line {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 50px 0 0;
        position: relative;
        z-index: 2;
    }

    /* ================= COPYRIGHT BAR ================= */
    .footer-copy {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
        position: relative;
        z-index: 2;
        padding: 20px 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ================= RESPONSIVE — MOBILE ================= */
    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 30px;
            text-align: center;
            padding: 0 20px;
        }

        .footer-logo {
            display: block;
            text-align: center;
        }

        .footer-logo-img {
            display: block;
            margin: 0 auto 16px;
        }

        .footer-tagline {
            max-width: 100%;
            text-align: center;
        }

        .site-footer h4::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-links a,
        .latest-posts a {
            padding-left: 0 !important;
        }

        .footer-contact p {
            justify-content: center;
            text-align: left;
        }

        .footer-copy {
            flex-direction: column;
            text-align: center;
            padding: 16px 20px;
        }

        .site-footer {
            padding-top: 50px;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-container">

        {{-- Column 1: Logo + Tagline + Latest Posts --}}
        <div>
            {{-- Show company logo image if set, otherwise fallback to text logo --}}
            @if($company && $company->logo)
                <img src="{{ asset($company->logo) }}"
                     alt="{{ $company->company_name ?? 'Company Logo' }}"
                     class="footer-logo-img">
            @else
                <div class="footer-logo">{{ $company->company_name ?? 'CrackerTime' }}</div>
            @endif

            @if($company && $company->address)
                <p class="footer-tagline">{{ $company->address }}</p>
            @else
                <p class="footer-tagline">Premium quality crackers for all your celebrations. Safe, colorful, and memorable moments guaranteed.</p>
            @endif

            <div class="latest-posts">
                <h4>Latest Posts</h4>
                <p><a href="{{ route('blog') }}#science-behind-the-sparkle">The Science Behind the Sparkle</a></p>
                <p><a href="{{ route('blog') }}#eco-friendly-crackers-2025">Top 10 Eco-Friendly Crackers</a></p>
                <p><a href="{{ route('blog') }}#cracker-safety-guide">Ultimate Guide to Cracker Safety</a></p>
            </div>
        </div>

        {{-- Column 2: Quick Links --}}
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('blog') }}">Blogs</a></li>
                <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
            </ul>
        </div>

        {{-- Column 3: Contact Info --}}
        <div class="footer-contact">
            <h4>Contact Info</h4>

            {{-- Phone --}}
            @if($company && $company->contact_number)
                <p>
                    <i class="fas fa-phone"></i>
                    <span>{{ $company->contact_number }}</span>
                </p>
            @else
                <p><i class="fas fa-phone"></i> +919488864547</p>
            @endif

            {{-- WhatsApp --}}
            @if($company && $company->whatsapp_number)
                <p>
                    <i class="fab fa-whatsapp"></i>
                    <span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp_number) }}"
                           target="_blank" class="footer-whatsapp-btn">
                            <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                        </a>
                    </span>
                </p>
            @endif

            {{-- Address --}}
            @if($company && $company->address)
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $company->address }}</span>
                </p>
            @else
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    Door No 2/554/C3, Southside school Near Sivakasi to Sattur main road, Mettamalai, Sivakasi - 626203
                </p>
            @endif

            {{-- Bank Details --}}
            @if($company && ($company->bank_ac_no || $company->bank_name))
                <div class="mt-3" style="border-top:1px solid rgba(255,255,255,0.1); padding-top:14px;">
                    <h4>Bank Details</h4>
                    @if($company->bank_name)
                        <p><i class="fas fa-university"></i> <span>{{ $company->bank_name }}</span></p>
                    @endif
                    @if($company->bank_ac_name)
                        <p><i class="fas fa-user"></i> <span>{{ $company->bank_ac_name }}</span></p>
                    @endif
                    @if($company->bank_ac_no)
                        <p><i class="fas fa-hashtag"></i> <span>A/C: {{ $company->bank_ac_no }}</span></p>
                    @endif
                    @if($company->bank_ac_type)
                        <p><i class="fas fa-layer-group"></i> <span>{{ $company->bank_ac_type }} Account</span></p>
                    @endif
                    @if($company->bank_ifsc)
                        <p><i class="fas fa-code"></i> <span>IFSC: {{ $company->bank_ifsc }}</span></p>
                    @endif
                </div>
            @endif
        </div>

    </div>

    <div class="footer-line"></div>

    <div class="footer-copy" style="margin-top: 30px;text-align: center;">
        <div>&copy; {{ date('Y') }} {{ $company->company_name ?? 'Crackers Time' }}. All rights reserved. | Delivery Available</div>
       
    </div>
</footer>
