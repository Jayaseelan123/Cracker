@extends('layouts.app')

@section('title', 'Privacy Policy | Kasthuri Crackers Sivakasi Crackers Shop')
@section('meta_description', 'Read the privacy policy of Kasthuri Crackers, a leading Sivakasi crackers shop, to understand how we protect your data on every online order.')
@section('hero_title', 'Privacy Policy')
@section('hero_subtitle', 'Your privacy matters to us. We protect your personal information and handle your data responsibly and securely')


@section('content')
    <style>
        body {
            background-color: #fdfaf6;
        }

        .privacy-hero-section {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: -24px;
            background: linear-gradient(90deg, #ff891a, #ff5e00);
            padding: 50px 0;
            color: white;
        }

        .privacy-hero-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .privacy-breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .privacy-breadcrumb a:hover {
            color: white;
        }

        .privacy-breadcrumb {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .privacy-hero-title {
            font-size: 42px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .privacy-hero-title span {
            font-size: 20px;
            font-weight: 500;
            text-transform: none;
            vertical-align: middle;
            color: #e0e0e0ff;
        }

        .privacy-hero-subtitle {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .privacy-hero-date {
            font-size: 13px;
            opacity: 0.7;
        }

        /* Cards */
        .privacy-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(231, 132, 40, 0.1);
        }

        .contents-card {
            background: #fff8f0;
            border: 1px solid #fce8d5;
        }

        .contents-title {
            font-size: 16px;
            font-weight: 700;
            color: #4a2e1b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contents-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
            column-count: 1;
        }

        @media (min-width: 768px) {
            .contents-list {
                column-count: 2;
            }
        }

        .contents-list li {
            margin-bottom: 8px;
        }

        .contents-list a {
            color: #d97706;
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .contents-list a:hover {
            color: #b45309;
            text-decoration: underline;
        }

        .privacy-warning {
            background-color: #f8fbff;
            border: 1px solid #e1effe;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            font-size: 14.5px;
            color: #3b526d;
            line-height: 1.6;
        }

        .privacy-warning strong {
            color: #1e3a5f;
        }

        .section-title-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #fdba74;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(234, 88, 12, 0.2);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            text-transform: uppercase;
        }

        /* Content styling */
        .privacy-content-text {
            font-size: 14.5px;
            color: #4b5563;
            line-height: 1.7;
        }

        .privacy-content-text p {
            margin-bottom: 15px;
        }

        .privacy-content-text ul {
            padding-left: 0;
            margin-bottom: 15px;
        }

        .privacy-content-text li {
            margin-bottom: 0;
            padding: 8px 0;
            position: relative;
            list-style: none;
            border-bottom: 1px solid #ffedd5;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .privacy-content-text li:last-child {
            border-bottom: none;
        }

        .privacy-content-text li::before {
            display: none;
        }

        .list-icon {
            color: #d97706;
            margin-top: 4px;
            font-size: 15px;
            min-width: 20px;
            text-align: center;
        }

        .privacy-content-text strong {
            color: #1f2937;
        }

        .gst-compliance {
            background-color: #fffaf0;
            border: 1px solid #fde68a;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 5px;
            font-size: 13.5px;
            color: #92400e;
        }

        .contact-box {
            background-color: #1e293b;
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-top: 15px;
        }

        .contact-title {
            color: #f97316;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .contact-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 14.5px;
            color: #e2e8f0;
        }

        .contact-detail i {
            color: #f97316;
            width: 16px;
            text-align: center;
        }

        .full-width-section {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: -24px;
            background: linear-gradient(90deg, #ff891a, #ff5e00);
            color: white;
        }
    </style>

    <!-- Breadcrumb & Hero Section -->
   <div class="full-width-section">
    <div class="container p-5" style="border-radius: 12px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255, 255, 255, 0.7);">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-white"><i
                            class="fas fa-home me-1"></i>Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page" style="opacity: 0.9;">Privacy Policy
                </li>
            </ol>
        </nav>
        <h1 class="fw-bold text-white mb-2">Your Privacy Matters</h1>
        <p class="text-white mb-0" style="font-size: 16px; opacity: 0.9;">We value your trust and take reasonable steps
            to protect the personal information you share with us while using our website and services.</p>
    </div>
</div>

    <div class="container py-5" style="max-width: 1000px;">

        <!-- Contents Box -->
        <div class="privacy-card contents-card">
            <div class="contents-title">
                <i class="fas fa-list me-2"></i> POLICY OVERVIEW
            </div>
            <ul class="contents-list">
                <li><a href="#section-1">1. Information We Receive</a></li>
                <li><a href="#section-2">2. How We Handle Your Information</a></li>
                <li><a href="#section-3">3. When Information Is Shared</a></li>
                <li><a href="#section-4">4. Cookies & Website Technologies</a></li>
                <li><a href="#section-5">5. Protecting Your Information</a></li>
                <li><a href="#section-6">6. Your Privacy Choices</a></li>
                <li><a href="#section-7">7. External Website Links</a></li>
                <li><a href="#section-8">8. Privacy of Young Visitors</a></li>
                <li><a href="#section-9">9. Policy Updates</a></li>
                <li><a href="#section-10">10. Get in Touch</a></li>
            </ul>
        </div>

        <!-- Warning Box -->
        <div class="privacy-warning">
            At <strong>Kasthuripyro</strong>, we value your trust and take reasonable steps to safeguard the information
            you share with us. This Privacy Policy describes how information is collected, used, and protected when you
            interact with our website and services.
            <br><br>
            By continuing to browse or use our website, you acknowledge and accept the practices described in this policy.
        </div>

        <!-- Section 1 -->
        <div class="privacy-card" id="section-1">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-file-alt"></i></div>
                <h4 class="section-title">1. INFORMATION WE RECEIVE</h4>
            </div>
            <div class="privacy-content-text">
                <p>Depending on how you interact with our website, we may receive the following information:</p>
                <ul>
                    <li><i class="fas fa-user list-icon"></i>
                        <div><strong>Customer Details:</strong> Your name, delivery address, phone number, email address,
                            and
                            applicable age confirmation.</div>
                    </li>

                    <li><i class="fas fa-shopping-cart list-icon"></i>
                        <div><strong>Purchase Details:</strong> Information about products selected, quantities, billing
                            information, and delivery requirements.</div>
                    </li>

                    <li><i class="far fa-credit-card list-icon"></i>
                        <div><strong>Payment References:</strong> Payment confirmations, screenshots, transaction
                            references,
                            or related details provided during an order. We do not intentionally retain complete card or
                            bank
                            account numbers.</div>
                    </li>

                    <li><i class="fas fa-comments list-icon"></i>
                        <div><strong>Customer Communications:</strong> Messages and enquiries shared through WhatsApp,
                            email,
                            telephone, or website contact forms.</div>
                    </li>

                    <li><i class="fas fa-globe list-icon"></i>
                        <div><strong>Website Activity:</strong> Technical information such as browser type, IP address,
                            visited pages, and referring source may be collected for website operation and analytics.</div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="privacy-card" id="section-2">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-sync-alt"></i></div>
                <h4 class="section-title">2. HOW WE HANDLE YOUR INFORMATION</h4>
            </div>
            <div class="privacy-content-text">
                <p>The information we receive may be used for the following purposes:</p>
                <ul>
                    <li><i class="fas fa-check list-icon"></i>
                        <div>To confirm, process, and fulfil customer orders.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>To provide order confirmations, dispatch information, and delivery-related updates.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>To answer customer questions and assist with service-related requests.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>To maintain and improve our website, products, services, and overall customer experience.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>To communicate relevant promotions, festive offers, and business announcements where permitted
                            and with appropriate consent.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>To meet applicable legal requirements and help identify or prevent suspicious or fraudulent
                            activity.</div>
                    </li>
                </ul>

                <div class="gst-compliance">
                    <strong>GST Compliance:</strong> Billing information may be used to prepare and issue GST invoices where
                    applicable under Indian tax requirements.
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="privacy-card" id="section-3">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-share-nodes"></i></div>
                <h4 class="section-title">3. WHEN INFORMATION IS SHARED</h4>
            </div>
            <div class="privacy-content-text">
                <p>We do not sell your personal information. Information may be shared only when necessary to provide our
                    services or meet legitimate legal and business requirements.</p>
                <ul>
                    <li><i class="fas fa-truck list-icon"></i>
                        <div><strong>Delivery Partners:</strong> Relevant customer details, such as name and delivery
                            address,
                            may be provided to logistics or transport partners for order fulfilment.</div>
                    </li>

                    <li><i class="fas fa-gavel list-icon"></i>
                        <div><strong>Legal Obligations:</strong> Information may be disclosed when required by applicable
                            law,
                            a valid court order, or an authorized government authority.</div>
                    </li>

                    <li><i class="fas fa-shield-alt list-icon"></i>
                        <div><strong>Business & Customer Protection:</strong> Information may be used or disclosed when
                            reasonably necessary to protect our business, customers, property, rights, or safety.</div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="privacy-card" id="section-4">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-cookie-bite"></i></div>
                <h4 class="section-title">4. COOKIES & WEBSITE TECHNOLOGIES</h4>
            </div>
            <div class="privacy-content-text">
                <p>Our website may use cookies and related browser technologies to support essential functions and
                    understand
                    how visitors interact with our online services:</p>
                <ul>
                    <li><i class="fas fa-circle list-icon" style="font-size: 8px; margin-top: 8px;"></i>
                        <div><strong>Session Cookies:</strong> Help maintain your browsing session and support shopping cart
                            functionality while you use the website.</div>
                    </li>

                    <li><i class="fas fa-circle list-icon" style="font-size: 8px; margin-top: 8px;"></i>
                        <div><strong>Analytics Technologies:</strong> May help us understand visitor activity, popular
                            pages,
                            and general website usage.</div>
                    </li>

                    <li><i class="fas fa-circle list-icon" style="font-size: 8px; margin-top: 8px;"></i>
                        <div><strong>Browser Storage:</strong> Certain cart-related information may be retained in your
                            browser to provide a smoother shopping experience.</div>
                    </li>
                </ul>

                <p>You can manage or disable cookies through your browser settings. Please note that restricting certain
                    technologies may affect some website features.</p>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="privacy-card" id="section-5">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-shield-alt"></i></div>
                <h4 class="section-title">5. PROTECTING YOUR INFORMATION</h4>
            </div>
            <div class="privacy-content-text">
                <p>We take reasonable technical and organizational measures to protect information against unauthorized
                    access, alteration, disclosure, or loss. Our safeguards may include:</p>
                <ul>
                    <li><i class="fas fa-check list-icon"></i>
                        <div>Controlled access to systems and customer information.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>Secure website connections and appropriate data transmission protections.</div>
                    </li>

                    <li><i class="fas fa-check list-icon"></i>
                        <div>Limiting access to customer information to authorized personnel where necessary.</div>
                    </li>
                </ul>

                <p>While we take reasonable precautions, no internet-based transmission or electronic storage method can be
                    guaranteed to be completely secure.</p>
            </div>
        </div>

        <!-- Section 6 -->
        <div class="privacy-card" id="section-6">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-user-lock"></i></div>
                <h4 class="section-title">6. YOUR PRIVACY CHOICES</h4>
            </div>
            <div class="privacy-content-text">
                <p>Subject to applicable laws and requirements, you may have the following choices regarding your personal
                    information:</p>
                <ul>
                    <li><i class="fas fa-eye list-icon"></i>
                        <div><strong>Access:</strong> Ask for information about the personal data we may hold about you.
                        </div>
                    </li>

                    <li><i class="fas fa-edit list-icon"></i>
                        <div><strong>Correction:</strong> Request that inaccurate or incomplete information be updated.
                        </div>
                    </li>

                    <li><i class="fas fa-trash-alt list-icon"></i>
                        <div><strong>Deletion:</strong> Request removal of personal information where permitted and subject
                            to applicable legal requirements.</div>
                    </li>

                    <li><i class="fas fa-sign-out-alt list-icon"></i>
                        <div><strong>Marketing Preferences:</strong> Choose to stop receiving promotional communications
                            where an unsubscribe option is available.</div>
                    </li>
                </ul>

                <p>For privacy-related requests or questions, please contact us using the details provided at the end of
                    this
                    page.</p>
            </div>
        </div>

        <!-- Section 7 -->
        <div class="privacy-card" id="section-7">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-external-link-alt"></i></div>
                <h4 class="section-title">7. EXTERNAL WEBSITE LINKS</h4>
            </div>
            <div class="privacy-content-text">
                <p>Our website may provide links to external services or websites, including social platforms and payment
                    services. These third-party websites operate under their own terms and privacy practices. We recommend
                    reviewing the privacy information provided by any external website before sharing personal information
                    with it.</p>
            </div>
        </div>

        <!-- Section 8 -->
        <div class="privacy-card" id="section-8">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-child"></i></div>
                <h4 class="section-title">8. PRIVACY OF YOUNG VISITORS</h4>
            </div>
            <div class="privacy-content-text">
                <p>Our services are intended for individuals who are 18 years of age or older. We do not knowingly request
                    or collect personal information from children under 18. If you believe that a minor has provided
                    personal
                    information through our website, please contact us so that appropriate action can be considered.</p>
            </div>
        </div>

        <!-- Section 9 -->
        <div class="privacy-card" id="section-9">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-history"></i></div>
                <h4 class="section-title">9. POLICY UPDATES</h4>
            </div>
            <div class="privacy-content-text">
                <p>We may revise this Privacy Policy when our services, website practices, or applicable legal requirements
                    change. Any revised version will be published on this page along with an updated policy date where
                    appropriate.</p>

                <p>We encourage visitors to review this page periodically so they remain informed about how their
                    information
                    is handled.</p>
            </div>
        </div>

        <!-- Section 10 -->
        <div class="privacy-card" id="section-10">
            <div class="section-title-wrapper">
                <div class="section-icon"><i class="fas fa-envelope"></i></div>
                <h4 class="section-title">10. GET IN TOUCH</h4>
            </div>
            <div class="privacy-content-text">
                <p>If you have questions, requests, or concerns regarding this Privacy Policy or the way your information is
                    handled, you can reach us using the contact details below:</p>

                <div class="contact-box">
                    <div class="contact-title">Contact Information</div>

                    <div class="contact-detail">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Door No: 3/1362,CA,Bharathi Nagar Sattur road, Sivakasi – 626189</span>
                    </div>

                    <div class="contact-detail">
                        <i class="fas fa-phone-alt"></i>
                        <span>+919787515558</span>
                    </div>

                    <div class="mt-3" style="font-size: 13px; color: #94a3b8;">
                        Support hours: 9:00 AM to 6:00 PM (Monday to Saturday)
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection