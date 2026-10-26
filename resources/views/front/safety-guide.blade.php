@extends('layouts.app')
@section('title', 'Fireworks Safety Guide | Kasthuri Crackers Sivakasi')
@section('meta_description', 'Read Kasthuri Crackers\'s fireworks safety guide before you buy Sivakasi crackers online. Tips for a fun, safe Diwali celebration with family.')

@section('hero_title', 'Safety Guide')
@section('hero_subtitle', 'Safe Usage • Do’s & Don’ts • Best Practices
')
@section('content')
    <style>
        .best-practices-section {

            border-radius: 20px;
        }

        .section-header-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #d97706;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .section-main-title {
            font-size: 32px;
            font-weight: 900;
            color: #1f2937;
        }

        .section-main-title span {
            color: #ea580c;
        }

        .title-divider {
            width: 60px;
            height: 3px;
            background-color: #ea580c;
            margin: 15px auto 20px;
        }

        .best-practice-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px 20px;
            height: 100%;
            text-align: center;
            box-shadow: 0 4px 15px rgba(234, 88, 12, 0.06);
            border: 1px solid rgba(234, 88, 12, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .best-practice-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(234, 88, 12, 0.12);
        }

        .practice-icon-box {
            width: 52px;
            height: 52px;
            background-color: #ea580c;
            color: #ffffff;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .best-practice-card h6 {
            font-size: 15.5px;
            font-weight: 700;
            color: #432c1b;
            margin-bottom: 12px;
        }

        .best-practice-card p {
            font-size: 13.5px;
            color: #c39361;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Do's and Don'ts Custom Cards */
        .dos-card {
            background-color: #f2fff5;
            border: 1px solid #bcf2cd;
            border-radius: 12px;
        }

        .dos-card .card-header-box {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #bcf2cd;
            margin-bottom: 20px;
        }

        .dos-card .header-icon {
            width: 40px;
            height: 40px;
            background-color: #1f9a55;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            margin-right: 15px;
        }

        .dos-card .header-title {
            font-size: 20px;
            font-weight: 700;
            color: #136c39;
            margin: 0;
        }

        .dos-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dos-list li {
            display: flex;
            align-items: flex-start;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #bcf2cd;
        }

        .dos-list li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .dos-list .list-icon {
            width: 28px;
            height: 28px;
            background-color: #1f9a55;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-right: 15px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .dos-list .list-text strong {
            color: #136c39;
            font-size: 14.5px;
            display: block;
            margin-bottom: 4px;
        }

        .dos-list .list-text span {
            color: #2d5a40;
            font-size: 14px;
        }

        .donts-card {
            background-color: #fff5f5;
            border: 1px solid #fec8c8;
            border-radius: 12px;
        }

        .donts-card .card-header-box {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #fec8c8;
            margin-bottom: 20px;
        }

        .donts-card .header-icon {
            width: 40px;
            height: 40px;
            background-color: #e84e4e;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            margin-right: 15px;
        }

        .donts-card .header-title {
            font-size: 20px;
            font-weight: 700;
            color: #a52b2b;
            margin: 0;
        }

        .donts-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .donts-list li {
            display: flex;
            align-items: flex-start;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #fec8c8;
        }

        .donts-list li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .donts-list .list-icon {
            width: 28px;
            height: 28px;
            background-color: #e84e4e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-right: 15px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .donts-list .list-text strong {
            color: #a52b2b;
            font-size: 14.5px;
            display: block;
            margin-bottom: 4px;
        }

        .donts-list .list-text span {
            color: #8c3b3b;
            font-size: 14px;
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
    </style>



    <!-- Breadcrumb & Hero Section -->
   <div class="full-width-section">
        <div class="container p-5" style="border-radius: 12px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255, 255, 255, 0.7);">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-white"><i
                                class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page" style="opacity: 0.9;">Safe Celebration
                    </li>
                </ol>
            </nav>
            <h1 class="fw-bold text-white mb-2">Celebrate With Care</h1>
            <p class="text-white mb-0" style="font-size: 16px; opacity: 0.9;">Practical guidance and responsible usage tips
                to
                help make every fireworks celebration safer and more enjoyable.</p>
        </div>
    </div>
    <div class="container py-5 my-3">

        <!-- Do's and Don'ts Section -->
        <div class="text-center mb-4">
            <div class="section-header-title">FIREWORK SAFETY</div>
            <div class="section-main-title">Smart Use & <span>Safe Celebration</span></div>
            <div class="title-divider"></div>
        </div>

        <div class="row g-4 mb-5">
            <!-- Do's -->
            <div class="col-lg-6">
                <div class="dos-card p-4 p-md-5 h-100">
                    <div class="card-header-box">
                        <div class="header-icon"><i class="fas fa-check"></i></div>
                        <h3 class="header-title">Safe Practices</h3>
                    </div>
                    <ul class="dos-list">
                        <li>
                            <div class="list-icon"><i class="fas fa-check"></i></div>
                            <div class="list-text">
                                <strong>Read Before Use</strong>
                                <span>Carefully follow every safety direction and usage instruction provided with the
                                    product.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-check"></i></div>
                            <div class="list-text">
                                <strong>Choose Trusted Products</strong>
                                <span>Purchase fireworks only from established and authorized sellers or
                                    manufacturers.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-check"></i></div>
                            <div class="list-text">
                                <strong>Select an Open Area</strong>
                                <span>Use fireworks outdoors in a clear location with sufficient space around the
                                    activity.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-check"></i></div>
                            <div class="list-text">
                                <strong>Prepare for Emergencies</strong>
                                <span>Keep water or suitable fire-safety resources close by before starting the
                                    celebration.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-check"></i></div>
                            <div class="list-text">
                                <strong>Give Everyone Space</strong>
                                <span>Light one item at a time and ensure spectators remain at an appropriate
                                    distance.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Don'ts -->
            <div class="col-lg-6">
                <div class="donts-card p-4 p-md-5 h-100">
                    <div class="card-header-box">
                        <div class="header-icon"><i class="fas fa-times"></i></div>
                        <h3 class="header-title">Avoid These Risks</h3>
                    </div>
                    <ul class="donts-list">
                        <li>
                            <div class="list-icon"><i class="fas fa-times"></i></div>
                            <div class="list-text">
                                <strong>Never Alter Fireworks</strong>
                                <span>Do not dismantle, modify, combine, or experiment with fireworks in any way.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-times"></i></div>
                            <div class="list-text">
                                <strong>Do Not Reignite</strong>
                                <span>Never approach, handle, or attempt to relight a firework that has failed to
                                    activate.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-times"></i></div>
                            <div class="list-text">
                                <strong>Keep Fireworks Away From Your Body</strong>
                                <span>Never carry fireworks in pockets, hands, or clothing while moving around.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-times"></i></div>
                            <div class="list-text">
                                <strong>Avoid Flammable Clothing</strong>
                                <span>Do not wear loose or highly flammable clothing while handling or lighting
                                    fireworks.</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"><i class="fas fa-times"></i></div>
                            <div class="list-text">
                                <strong>Leave Unused Debris Alone</strong>
                                <span>Do not touch or collect leftover fireworks immediately after the celebration.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="best-practices-section mb-5">
            <div class="w-100">
                <div class="text-center mb-5">
                    <div class="section-header-title">CELEBRATION GUIDELINES</div>
                    <div class="section-main-title">Essential <span>Safety Tips</span></div>
                    <div class="title-divider"></div>
                    <p class="text-muted">Keep these practical precautions in mind for a safer and more responsible
                        celebration.</p>
                </div>

                <div class="row justify-content-center g-4">
                    <!-- Adult Supervision -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-child"></i>
                            </div>
                            <h6>Supervise Children</h6>
                            <p>Children should only be around fireworks when a responsible adult is actively supervising
                                them.</p>
                        </div>
                    </div>

                    <!-- Protect Your Eyes -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h6>Shield Your Eyes</h6>
                            <p>Use suitable eye protection when appropriate and keep your face away from the lighting area.
                            </p>
                        </div>
                    </div>

                    <!-- Right Clothing -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <h6>Dress Safely</h6>
                            <p>Choose comfortable, close-fitting cotton clothing and stay away from easily ignitable
                                fabrics.</p>
                        </div>
                    </div>

                    <!-- Open Spaces -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h6>Clear the Surroundings</h6>
                            <p>Select a spacious area away from buildings, trees, vehicles, electrical wires, and other
                                hazards.</p>
                        </div>
                    </div>

                    <!-- Soak Used Fireworks -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-tint"></i>
                            </div>
                            <h6>Handle Waste Carefully</h6>
                            <p>Allow used fireworks to cool completely and follow safe disposal practices after the
                                celebration.</p>
                        </div>
                    </div>

                    <!-- First Aid -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-medkit"></i>
                            </div>
                            <h6>Keep First Aid Ready</h6>
                            <p>Have basic first-aid supplies available and seek professional medical assistance for serious
                                injuries.</p>
                        </div>
                    </div>

                    <!-- Protect Pets -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-dog"></i>
                            </div>
                            <h6>Keep Pets Comfortable</h6>
                            <p>Keep pets in a secure indoor space where they can stay protected from loud sounds and bright
                                flashes.</p>
                        </div>
                    </div>

                    <!-- Safe Storage -->
                    <div class="col-md-6 col-lg-3">
                        <div class="best-practice-card">
                            <div class="practice-icon-box">
                                <i class="fas fa-box"></i>
                            </div>
                            <h6>Store With Care</h6>
                            <p>Keep fireworks in their original packaging in a cool, dry location away from heat and
                                children.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Section -->
        <div class="alert border-0 shadow-sm rounded-4 p-4 d-flex align-items-start mb-4"
            style="background-color: #090330ff; border-left: 5px solid #eb8212ff !important;">
            <div class="fs-1 me-4 mt-1" style="color: #21ccf3ff;">
                &#9888;&#65039;
            </div>
            <div>
                <h5 class="fw-bold" style="color: #f0830eff;">Essential Safety Reminder</h5>
                <p class="mb-0" style="color: #c2b2b2;
                                                                ; line-height: 1.8; opacity: 0.9;">
                    Fireworks require careful handling and responsible use. <strong class="text-white"
                        style="opacity: 1;">Never</strong>
                    aim fireworks toward people, animals, vehicles, or property. Keep spectators at a safe distance and
                    follow all product instructions and applicable local regulations. In an emergency, contact
                    <strong class="text-white" style="opacity: 1;">112</strong> immediately. Always prioritize safety
                    throughout
                    your celebration.
                </p>
            </div>
        </div>

        <div class="mt-5 p-4 rounded-4 d-flex flex-column flex-md-row align-items-center justify-content-between"
            style="background-color: #faebd7; border: 1px solid #f4ae6eff;">
            <p class="mb-3 mb-md-0" style="color: #000000ff; font-size: 15px;">
                Please also review our complete <span class="fw-bold" style="color: #8f4618;">Booking Terms &
                    Conditions</span>
                for important information about orders, delivery schedules, and applicable policies.
            </p>
            <a href="{{ route('terms') }}"
                class="btn text-white px-4 py-2 fw-semibold rounded-pill d-flex align-items-center shadow-sm"
                style="background-color: #e75212ff; font-size: 14.5px;">
                <i class="fas fa-file-alt me-2"></i> View Booking Terms
            </a>
        </div>

    </div>
@endsection