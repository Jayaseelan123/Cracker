@extends('layouts.app')

@section('title', 'Terms & Conditions | Kasthuri Crackers')
@section('meta_description', 'Read the terms and conditions for shopping with Kasthuri Crackers, your trusted online crackers Sivakasi destination for safe, secure purchases.')
@section('hero_title', 'Terms and Conditions')
@section('hero_subtitle', 'Please read these terms carefully before using our website')

@section('content')
    <style>
        body {
            background-color: #fdfaf6;
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
            padding: 20px 0;
            color: white;
        }

        .terms-hero-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .terms-breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .terms-breadcrumb a:hover {
            color: white;
        }

        .terms-breadcrumb {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .terms-hero-title {
            font-size: 42px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .terms-hero-title span {
            font-size: 20px;
            font-weight: 500;
            text-transform: none;
            vertical-align: middle;
            color: #e0e0e0ff;
        }

        .terms-hero-subtitle {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        /* Cards */
        .terms-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(231, 132, 40, 0.1);
        }

        /* Section Title */
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
            font-weight: 800;
            color: #4a2e1b;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Content styling */
        .terms-content-text {
            font-size: 14.5px;
            color: #4b5563;
            line-height: 1.8;
        }

        .terms-content-text p {
            margin-bottom: 15px;
        }

        /* List styling mimicking the image */
        .terms-content-text ul {
            padding-left: 0;
            margin-bottom: 15px;
        }

        .terms-content-text li {
            margin-bottom: 0;
            padding: 6px 0;
            position: relative;
            list-style: none;
            border-bottom: 1px solid #ffedd5;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .terms-content-text li:last-child {
            border-bottom: none;
        }

        /* Bullet point for lists */
        .terms-content-text li::before {
            content: "";
            background-color: #d97706;
            margin-top: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .terms-content-text strong {
            color: #1f2937;
        }

        /* For delivery boxes if used */
        .delivery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .delivery-grid {
                grid-template-columns: 1fr;
            }
        }

        .delivery-box {
            background-color: #fff4eb;
            border: 1px solid #fce8d5;
            border-radius: 8px;
            padding: 25px 15px;
            text-align: center;
        }

        .delivery-box .loc {
            color: #6b4f3a;
            font-weight: 700;
            font-size: 13.5px;
            margin-bottom: 15px;
        }

        .delivery-box .loc i {
            color: #8b6d53;
            margin-right: 5px;
        }

        .delivery-box .days {
            color: #ea580c;
            font-size: 48px;
            font-weight: 900;
            line-height: 1;
        }

        .delivery-box .label {
            color: #a8927f;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        /* Safety Guide Banner */
        .safety-guide-banner {
            background-color: #171c26;
            /* Dark slate */
            border-radius: 8px;
            padding: 20px 30px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #e2e8f0;
            gap: 20px;
        }

        .safety-text {
            font-size: 15px;
        }

        .safety-text .text-orange {
            color: #ff6b00;
            /* Vibrant orange */
            font-weight: 700;
        }

        .btn-safety {
            background-color: #ff6b00;
            color: #fff;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: background-color 0.3s;
        }

        .btn-safety:hover {
            background-color: #e66000;
            color: #fff;
        }

        @media (max-width: 768px) {
            .safety-guide-banner {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }
        }
    </style>

    <div class="full-width-section">
        <div class="container p-5" style="border-radius: 12px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255, 255, 255, 0.7);">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-white"><i
                                class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page" style="opacity: 0.9;">Terms &
                        conditions
                    </li>
                </ol>
            </nav>
            <h1 class="fw-bold text-white mb-2">Terms & Conditions</h1>
            <p class="text-white mb-0" style="font-size: 16px; opacity: 0.9;">Please read these terms carefully before
                using our website.
            </p>
        </div>
    </div>
    <div class="container py-5" style="max-width: 1000px;">
        @if(isset($sections) && $sections->count() > 0)
            @foreach($sections as $index => $section)
                <div class="terms-card">
                    <div class="section-title-wrapper">
                        @php
                            $icon = 'fas fa-file-contract';
                            $titleLower = strtolower($section->title_en);
                            if (str_contains($titleLower, 'shipping') || str_contains($titleLower, 'transport')) {
                                $icon = 'fas fa-truck';
                            } elseif (str_contains($titleLower, 'delivery')) {
                                $icon = 'fas fa-clock';
                            } elseif (str_contains($titleLower, 'payment') || str_contains($titleLower, 'price')) {
                                $icon = 'far fa-credit-card';
                            } elseif (str_contains($titleLower, 'return') || str_contains($titleLower, 'cancel')) {
                                $icon = 'fas fa-undo';
                            } elseif (str_contains($titleLower, 'general') || str_contains($titleLower, 'condition') || str_contains($titleLower, 'term')) {
                                $icon = 'fas fa-gavel';
                            }
                        @endphp
                        <div class="section-icon"><i class="{{ $icon }}"></i></div>
                        <h4 class="section-title">{{ $section->title_en }}</h4>
                    </div>

                    <div class="terms-content-text">
                        @php
                            $text = $section->content_en;
                            // Check if it's plain text (no HTML tags)
                            if (strip_tags($text) === $text && !empty(trim($text))) {
                                // Split by newlines
                                $lines = preg_split('/\r\n|\r|\n/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
                                $html = '<ul>';
                                foreach ($lines as $line) {
                                    // Remove any leading numbers like "1.", "2." if they added them manually
                                    $cleanLine = trim(preg_replace('/^\d+\.\s*/', '', $line));
                                    if ($cleanLine !== '') {
                                        $html .= '<li><div>' . $cleanLine . '</div></li>';
                                    }
                                }
                                $html .= '</ul>';
                                $text = $html;
                            }
                        @endphp
                        {!! $text !!}

                        @if($section->title_ta || $section->content_ta)
                            <div class="mt-4 pt-3 border-top">
                                @if($section->title_ta)
                                    <h5 class="fw-bold mb-3" style="color: #4a2e1b;">{{ $section->title_ta }}</h5>
                                @endif
                                {!! $section->content_ta !!}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="terms-card">
                <p class="text-muted mb-0">Terms and conditions will be updated soon.</p>
            </div>
        @endif

        {{-- Safety Guide CTA Banner --}}
        <div class="safety-guide-banner">
            <div class="safety-text">
                Also read our <span class="text-orange">Fireworks Safety Guide</span> — Do's & Don'ts and Safety Tips for
                safe fireworks usage.
            </div>
            <a href="{{ route('safety.guide') }}" class="btn-safety">
                <i class="fas fa-shield-alt"></i> View Safety Guide
            </a>
        </div>
    </div>
@endsection