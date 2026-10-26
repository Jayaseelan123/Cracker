@extends('layouts.app')

@section('title', 'Contact Us | Kasthuri Crackers Sivakasi Crackers Online')
@section('meta_description', 'Get in touch with Kasthuri Crackers for orders, queries or support. Reach Sivakasi\'s trusted online crackers shop for a hassle-free festive season.')
@section('hero_title', 'Get in Touch')
@section('hero_subtitle', 'Get in Touch With Us Today')

@section('content')
    <style>
        /* ── LAYOUT ── */
        .contact-wrap {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 45px rgba(0, 0, 0, .09);
            overflow: hidden;
            margin-bottom: 40px;
        }

        /* ── LEFT PANEL (Info) ── */
        .contact-info-panel {
            background: linear-gradient(160deg, #0d6b8a 0%, #0a4f68 100%);
            padding: 48px 38px;
            color: #fff;
            position: relative;
            overflow: hidden;
            min-height: 100%;
        }

        .contact-info-panel::before {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            top: -80px;
            right: -80px;
        }

        .contact-info-panel::after {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            bottom: -40px;
            left: -40px;
        }

        .contact-info-panel h3 {
            font-size: 1.55rem;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .contact-info-panel .sub {
            font-size: .9rem;
            opacity: .8;
            margin-bottom: 36px;
            position: relative;
            z-index: 1;
        }

        /* Info Items */
        .ci-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
        }

        .ci-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            backdrop-filter: blur(6px);
        }

        .ci-item .ci-label {
            font-size: .78rem;
            opacity: .7;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .ci-item .ci-value {
            font-size: .95rem;
            font-weight: 600;
            line-height: 1.5;
            color: #fff;
            text-decoration: none;
        }

        .ci-item a.ci-value:hover {
            opacity: .85;
        }

        /* Hours badge */
        .hours-badge {
            background: rgba(255, 255, 255, .12);
            border-radius: 12px;
            padding: 16px 18px;
            position: relative;
            z-index: 1;
            margin-top: 10px;
        }

        .hours-badge .hb-row {
            display: flex;
            justify-content: space-between;
            font-size: .88rem;
            margin-bottom: 6px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            padding-bottom: 6px;
        }

        .hours-badge .hb-row:last-child {
            margin-bottom: 0;
            border: none;
            padding: 0;
        }

        /* Social icons */
        .social-row {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            position: relative;
            z-index: 1;
        }

        .s-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            transition: background .25s, transform .25s;
        }

        .s-btn:hover {
            background: #ff9900;
            transform: translateY(-3px);
            color: #fff;
        }

        /* CTA Buttons */
        .cta-btns {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .cta-btns a {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 700;
            font-size: .88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: transform .25s, box-shadow .25s;
        }

        .cta-btns a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .2);
        }

        .btn-call {
            background: #ff9900;
            color: #fff;
        }

        .btn-wa {
            background: #25d366;
            color: #fff;
        }

        /* ── RIGHT PANEL (Form) ── */
        .contact-form-panel {
            padding: 48px 42px;
        }

        .contact-form-panel h3 {
            font-size: 1.55rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .contact-form-panel .sub {
            font-size: .9rem;
            color: #888;
            margin-bottom: 32px;
        }

        /* Form Fields */
        .field-group {
            margin-bottom: 22px;
        }

        .field-group label {
            font-size: .82rem;
            font-weight: 700;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 8px;
            display: block;
        }

        .field-group .form-control {
            border: 1.5px solid #e8e8e8;
            border-radius: 10px;
            padding: 13px 16px;
            font-size: .95rem;
            color: #333;
            transition: border-color .25s, box-shadow .25s;
            background: #fafafa;
        }

        .field-group .form-control:focus {
            border-color: #0d6b8a;
            box-shadow: 0 0 0 3px rgba(13, 107, 138, .12);
            background: #fff;
            outline: none;
        }

        .field-group .form-control.is-invalid {
            border-color: #dc3545;
        }

        .field-group textarea.form-control {
            resize: vertical;
            min-height: 140px;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(135deg, #0d6b8a, #0a4f68);
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px 40px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 107, 138, .35);
        }

        /* Success Alert */
        .success-alert {
            background: linear-gradient(135deg, #e8f8f0, #d4f4e6);
            border: 1.5px solid #2ecc71;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .success-alert .sa-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2ecc71;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
        }

        .success-alert p {
            margin: 0;
            color: #1a6b3c;
            font-weight: 600;
            font-size: .95rem;
        }

        /* ── MAP STRIP ── */
        .map-strip {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 25px rgba(0, 0, 0, .08);
            margin-bottom: 40px;
        }

        .map-strip iframe {
            display: block;
            width: 100%;
            height: 280px;
            border: none;
        }

        /* ── FAQ STRIP ── */
        .faq-row {
            margin-bottom: 40px;
        }

        .faq-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff9900, #ff6600);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 30px;
            margin-bottom: 12px;
        }

        .faq-item {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .06);
            margin-bottom: 12px;
            overflow: hidden;
        }

        .faq-q {
            padding: 16px 20px;
            font-weight: 700;
            color: #1a1a2e;
            font-size: .95rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .faq-q .faq-arrow {
            transition: transform .3s;
            font-size: 13px;
            color: #ff9900;
        }

        .faq-item.open .faq-arrow {
            transform: rotate(180deg);
        }

        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease, padding .35s ease;
            font-size: .9rem;
            color: #666;
            line-height: 1.75;
            padding: 0 20px;
        }

        .faq-item.open .faq-a {
            max-height: 200px;
            padding: 0 20px 16px;
        }

        /* ── ANIMATE ── */
        .animate {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .animate.show {
            opacity: 1;
            transform: translateY(0);
        }

        .d1 {
            transition-delay: .1s;
        }

        .d2 {
            transition-delay: .2s;
        }

        .d3 {
            transition-delay: .3s;
        }

        @media (max-width: 767px) {
            .contact-form-panel {
                padding: 30px 22px;
            }

            .contact-info-panel {
                padding: 32px 22px;
            }
        }
    </style>

    <!-- ═══ MAIN CONTACT CARD ═══ -->
    <div class="contact-wrap animate d1">
        <div class="row g-0">

            <!-- LEFT — Info Panel -->
            @php $companyInfo = \App\Models\CompanyDetail::first(); @endphp
            <div class="col-lg-5">
                <div class="contact-info-panel h-100">
                    <h3>Get In Touch 👋</h3>
                    <div class="ci-item">
                        <div class="ci-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="ci-label">Phone / WhatsApp</div>
                            <a href="tel:+91{{ $companyInfo->contact_number }}" class="ci-value">
                                +91 {{ $companyInfo->contact_number }}<br>
                                @if($companyInfo->whatsapp_number)
                                    +91 {{ $companyInfo->whatsapp_number }}
                                @endif
                            </a>
                        </div>
                    </div>

                    <div class="ci-item">
                        <div class="ci-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="ci-label">Email Address</div>
                            <a href="mailto:kasthuricrackers29@gmail.com" class="ci-value">kasthuricrackers29@gmail.com</a>
                        </div>
                    </div>

                    <div class="ci-item">
                        <div class="ci-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="ci-label">Office Address</div>
                            <span class="ci-value">{!! nl2br(e($companyInfo->address)) !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT — Form Panel -->
            <div class="col-lg-7">
                <div class="contact-form-panel">
                    <h3>Send Us a Message ✉️</h3>
                    <p class="sub">Fill in the form below and we'll get back to you within 24 hours.</p>

                    @if(session('success'))
                        <div class="success-alert">
                            <div class="sa-icon"><i class="fas fa-check"></i></div>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label for="contact_name">Your Name *</label>
                                    <input type="text" id="contact_name" name="name" value="{{ old('name') }}"
                                        placeholder="E.g. Ravi Kumar"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label for="contact_email">Email Address *</label>
                                    <input type="email" id="contact_email" name="email" value="{{ old('email') }}"
                                        placeholder="you@example.com"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="field-group">
                            <label for="contact_message">Your Message *</label>
                            <textarea id="contact_message" name="message"
                                placeholder="Tell us about your requirement, bulk order, or any question..."
                                class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>



   <!-- ═══ FAQ ═══ -->
    <div class="faq-row animate d3">

        <!-- FAQ Heading -->
        <div class="text-center mb-4">

            <span class="faq-badge">
                FAQ
            </span>

            <h3 style="
                    font-size:1.55rem;
                    font-weight:800;
                    color:#1a1a2e;
                ">
                Everything You Need to Know
            </h3>

        </div>


        <div class="row g-4">

            <!-- Left Column -->
            <div class="col-lg-6">

                <!-- FAQ 1 -->
                <div class="faq-item">

                    <div class="faq-q" onclick="toggleFaq(this)">
                        How can I place an order?
                        <span class="faq-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div class="faq-a">
                        Browse our product collection, select the items and quantities you need,
                        add them to your cart, and continue through the checkout process to submit
                        your order.
                    </div>

                </div>


                <!-- FAQ 2 -->
                <div class="faq-item">

                    <div class="faq-q" onclick="toggleFaq(this)">
                        Can I order different types of crackers together?
                        <span class="faq-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div class="faq-a">
                        Yes. You can select products from different categories and add them to the
                        same cart, making it convenient to prepare a complete celebration order in
                        one place.
                    </div>

                </div>


                <!-- FAQ 3 -->
                <div class="faq-item">

                    <div class="faq-q" onclick="toggleFaq(this)">
                        Can I purchase crackers for a family function or event?
                        <span class="faq-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div class="faq-a">
                        Yes. You can choose products based on your event and required quantity.
                        For larger requirements, contact our team to discuss your order details
                        and available options.
                    </div>

                </div>

            </div>


            <!-- Right Column -->
            <div class="col-lg-6">

                <!-- FAQ 4 -->
                <div class="faq-item">

                    <div class="faq-q" onclick="toggleFaq(this)">
                        How will I know if my order has been confirmed?
                        <span class="faq-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div class="faq-a">
                        After successfully placing your order, you will receive the available
                        order confirmation details. If you have any questions about your order,
                        you can contact our support team.
                    </div>

                </div>


                <!-- FAQ 5 -->
                <div class="faq-item">

                    <div class="faq-q" onclick="toggleFaq(this)">
                        Can I contact you before placing an order?
                        <span class="faq-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div class="faq-a">
                        Of course. If you need help selecting products, understanding an item,
                        checking order details, or discussing a larger requirement, you can
                        reach out to our team before placing your order.
                    </div>

                </div>


                <!-- FAQ 6 -->
                <div class="faq-item">

                    <div class="faq-q" onclick="toggleFaq(this)">
                        Do you have options for different types of celebrations?
                        <span class="faq-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div class="faq-a">
                        Yes. Our collection is suitable for a variety of occasions including
                        festivals, family celebrations, weddings, birthdays, special functions,
                        and other memorable moments.
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function toggleFaq(el) {
            const item = el.parentElement;
            item.classList.toggle('open');
        }
        document.addEventListener("DOMContentLoaded", () => {
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => { if (e.isIntersecting) e.target.classList.add("show"); });
            }, { threshold: 0.1 });
            document.querySelectorAll(".animate").forEach(el => obs.observe(el));
        });
    </script>

@endsection