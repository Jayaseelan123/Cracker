@extends('layouts.app')

@section('title', 'Shop')

@section('hero_title', 'Welcome to CrackerTime')
@section('hero_subtitle', 'Shop the best festive crackers')

@section('content')
    <!-- CATEGORIES EXPLORER (Image Style) -->
    @if(\App\Models\SiteSetting::bool('enable_category_filter', true))
    <div class="category-explorer-section mb-5">
        <div class="section-title-wrapper text-center mb-5">
            <h2 class="section-title">Explore Categories</h2>
            <div class="title-underline"></div>
        </div>
        
        <div class="category-carousel-container">
            <button class="carousel-nav-btn prev" id="catPrev"><i class="fas fa-chevron-left"></i></button>
            <div class="category-grid carousel-scroll" id="catCarousel">
                @foreach($categories as $category)
                @php 
                    $firstProduct = $category->products->first();
                    $catImg = $firstProduct ? asset('product_images/' . ($firstProduct->image_path ?: $firstProduct->image ?: 'demo.jpg')) : asset('images/category-placeholder.jpg');
                @endphp
                <a href="#cat-{{ $category->slug ?? Str::slug($category->name) }}" class="category-card nav-category-link">
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

    <!-- PRODUCTS SECTION START -->
    @if(\App\Models\SiteSetting::bool('show_pricelist_home', true))
    <div id="products-list" class="text-center mb-5 mt-5" style="scroll-margin-top: 80px;">
        <h2 class="section-title">Our Products</h2>
        <div class="title-underline"></div>
        <p class="text-muted mt-2">Browse our wide range of premium crackers</p>
    </div>

    @if(\App\Models\SiteSetting::bool('enable_search_filter', true))
    <div class="search-filter-container container mb-5" style="max-width: 500px;">
        <div class="input-group shadow-sm rounded-pill overflow-hidden border" style="background:#fff;">
            <span class="input-group-text bg-white border-0 ps-3">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" id="productSearchInput" class="form-control border-0 py-2 ps-2" placeholder="Search products by name or code..." style="outline: none; box-shadow: none;">
            <button class="btn border-0 bg-white pe-3" type="button" id="clearSearchBtn" style="display: none;">
                <i class="fas fa-times text-muted"></i>
            </button>
        </div>
    </div>
    @endif

    @foreach($categories as $category)
        <div class="category-header" id="cat-{{ $category->slug ?? Str::slug($category->name) }}">
            <i class="fas fa-fire"></i>
            {{ $category->name }}
        </div>

        <div class="table-responsive">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Image</th>
                        <th style="text-align:left;">Product</th>
                        @if(\App\Models\SiteSetting::bool('show_discount_row', true))
                        <th style="text-align:center;">MRP</th>
                        @endif
                        <th style="text-align:center;">Price</th>
                        <th style="text-align:center;">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->products as $product)
                        @php
                            $productImg   = asset('product_images/' . ($product->image_path ?: $product->image ?: 'demo.jpg'));
                            $vid = '';
                            if (($product->video_status ?? 'Active') === 'Active') {
                                // Prioritize local MP4 file upload over YouTube URL
                                if (!empty($product->video)) {
                                    $vid = asset('product_videos/' . $product->video);
                                } elseif (!empty($product->video_url)) {
                                    $vid = $product->video_url;
                                }
                            }
                            $productVideo = $vid;
                            $productName  = addslashes($product->name_en ?? $product->name ?? '');
                            $productTa    = addslashes($product->name_ta ?? '');
                            $productMrp   = number_format($product->mrp, 2);
                            $productPrice = number_format($product->price, 2);
                        @endphp
                        <tr class="product-row">
                            <td style="text-align:left; cursor:pointer;"
                                onclick="showProductCarousel('{{ $productName }}','{{ $productTa }}','{{ $productImg }}','{{ $productMrp }}','{{ $productPrice }}','{{ $productVideo }}')">
                                @if($vid)
                                    <div style="position:relative;display:inline-block;">
                                        <img src="{{ $productImg }}" alt="{{ $product->name_en ?? $product->name }}">
                                        <span style="position:absolute;bottom:3px;right:3px;background:rgba(0,0,0,0.6);border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-play" style="color:#fff;font-size:9px;margin-left:2px;"></i>
                                        </span>
                                    </div>
                                @else
                                    <img src="{{ $productImg }}" alt="{{ $product->name_en ?? $product->name }}">
                                @endif
                            </td>
                            <td style="text-align:left; cursor:pointer;"
                                onclick="showProductCarousel('{{ $productName }}','{{ $productTa }}','{{ $productImg }}','{{ $productMrp }}','{{ $productPrice }}','{{ $productVideo }}')">
                                @if(\App\Models\SiteSetting::bool('show_product_code', false) && !empty($product->sku))
                                    <div class="text-primary small fw-bold mb-1">Code: {{ $product->sku }}</div>
                                @endif
                                <div>{{ $product->name_en ?? $product->name ?? '—' }}</div>
                                @if(!empty($product->name_ta))
                                    <div class="text-muted small">{{ $product->name_ta }}</div>
                                @endif
                                @if($vid)
                                    <div class="mt-1"><span class="badge" style="background:#0a4f68;font-size:10px;"><i class="fas fa-video me-1"></i>Has Video</span></div>
                                @endif
                            </td>
                            @if(\App\Models\SiteSetting::bool('show_discount_row', true))
                            <td style="text-align:center; font-weight: bold; font-size: 1.1em; color: #333;">{{ \App\Models\SiteSetting::get('price_format', 'INR') }} {{ number_format($product->mrp, 2) }}</td>
                            @endif
                            <td style="text-align:center; font-weight: bold; font-size: 1.1em; color: #333;">{{ \App\Models\SiteSetting::get('price_format', 'INR') }} {{ number_format($product->price, 2) }}</td>
                            @php $cartItems = session('cart', []);
                            $cartQty = $cartItems[$product->id] ?? 0; @endphp
                            <td style="text-align:center;">
                                @if($product->stock > 0)
                                    <div class="qty-controls" style="justify-content:center;">
                                        <button type="button" data-id="{{ $product->id }}"
                                            class="qty-btn minus qty-minus-btn">-</button>
                                        <input type="text" readonly class="qty-input qty-display-{{ $product->id }}"
                                            value="{{ $cartQty }}">
                                        <button type="button" data-id="{{ $product->id }}" class="qty-btn plus qty-plus-btn">+</button>
                                    </div>
                                    <div class="text-success small mt-1">In Stock: {{ $product->stock }}</div>
                                @else
                                    <div class="text-danger fw-bold">Out of Stock</div>
                                    <div class="qty-controls" style="justify-content:center; opacity: 0.5; pointer-events: none;">
                                        <button type="button" class="qty-btn minus" disabled>-</button>
                                        <input type="text" readonly class="qty-input" value="0">
                                        <button type="button" class="qty-btn plus" disabled>+</button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No products in this category.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach
    @endif

    {{-- ============================================================
         PRODUCT IMAGE + VIDEO CAROUSEL LIGHTBOX MODAL
    ============================================================ --}}
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">

                {{-- Header --}}
                <div class="modal-header border-0 px-4 py-3"
                     style="background:linear-gradient(135deg,#0a4f68,#1a8ab0);">
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="productModalLabel"></h5>
                        <p class="text-white opacity-75 small mb-0" id="modalProductTaName"></p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Carousel body --}}
                <div class="modal-body p-0" style="background:#111;min-height:360px;">
                    <div id="productCarousel" class="carousel slide h-100" data-bs-ride="false">

                        <div class="carousel-inner" id="carouselInner"
                             style="background:#111;min-height:360px;">
                            {{-- slides injected by JS --}}
                        </div>

                        {{-- Prev / Next --}}
                        <button class="carousel-control-prev d-none" id="carouselPrev"
                                type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next d-none" id="carouselNext"
                                type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        {{-- Dot indicators --}}
                        <div class="carousel-indicators d-none" id="carouselIndicators">
                            <button type="button" data-bs-target="#productCarousel"
                                    data-bs-slide-to="0" class="active" aria-label="Image"></button>
                            <button type="button" data-bs-target="#productCarousel"
                                    data-bs-slide-to="1" aria-label="Video"></button>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0 px-4 py-3 justify-content-center"
                     style="background:#f8fafc;">
                    <div class="d-flex align-items-center gap-4">
                        <span class="text-muted text-decoration-line-through fs-6">
                            MRP: ₹<span id="modalProductMrp"></span>
                        </span>
                        <span class="fw-bold text-success" style="font-size:1.4rem;">
                            Price: ₹<span id="modalProductPrice"></span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== STYLES ===== --}}
    <style>
        /* The carousel-inner must have a solid dark bg and fixed height */
        #productModal .carousel-inner {
            background: #111 !important;
            min-height: 360px;
        }

        /*
           IMPORTANT: Bootstrap sets .carousel-item { display:none }
           and .carousel-item.active { display:block }
           DO NOT override display on .carousel-item.
           Use a wrapper inside each item for centering.
        */
        #productModal .slide-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 360px;
            background: #111;
        }

        #productModal .slide-wrap img {
            max-height: 340px;
            max-width: 100%;
            object-fit: contain;
        }

        #productModal .slide-wrap video {
            max-height: 340px;
            max-width: 100%;
            width: 100%;
            object-fit: contain;
            background: #000;
        }

        /* Label badge top-left */
        #productModal .slide-badge {
            position: absolute;
            top: 10px;
            left: 14px;
            background: rgba(0,0,0,0.6);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 3px 12px;
            border-radius: 50px;
            z-index: 10;
        }
    </style>

    {{-- ===== JAVASCRIPT ===== --}}
    <script>
    function showProductCarousel(name, taName, imageUrl, mrp, price, videoUrl) {

        // Fill header & price
        document.getElementById('productModalLabel').innerText  = name;
        document.getElementById('modalProductTaName').innerText = taName || '';
        document.getElementById('modalProductMrp').innerText    = mrp;
        document.getElementById('modalProductPrice').innerText  = price;

        const inner      = document.getElementById('carouselInner');
        const indicators = document.getElementById('carouselIndicators');
        const prevBtn    = document.getElementById('carouselPrev');
        const nextBtn    = document.getElementById('carouselNext');
        const carouselEl = document.getElementById('productCarousel');

        // Pause & reset any existing video/iframe
        inner.querySelectorAll('video').forEach(function(v){ v.pause(); v.currentTime = 0; });
        inner.querySelectorAll('iframe').forEach(function(f){
            try { f.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*'); } catch(e){}
        });

        // Clear slides
        inner.innerHTML = '';

        const hasVideo = videoUrl && videoUrl.trim() !== '';

        if (hasVideo) {
            // -- Detect YouTube links --
            let isYouTube = false;
            let youtubeWatchUrl = videoUrl; // original URL for opening in YT
            let videoId = '';

            if (videoUrl.includes('youtube.com/shorts/')) {
                videoId = videoUrl.split('shorts/')[1].split('?')[0];
                isYouTube = true;
                youtubeWatchUrl = 'https://www.youtube.com/shorts/' + videoId;
            } else if (videoUrl.includes('youtube.com/watch')) {
                try { videoId = new URL(videoUrl).searchParams.get('v'); } catch(e){}
                isYouTube = true;
                youtubeWatchUrl = 'https://www.youtube.com/watch?v=' + videoId;
            } else if (videoUrl.includes('youtu.be/')) {
                videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                isYouTube = true;
                youtubeWatchUrl = 'https://www.youtube.com/watch?v=' + videoId;
            }

            if (isYouTube && videoId) {
                // YouTube: embed inline using privacy-enhanced nocookie domain (bypasses many embed restrictions)
                const embedUrl = 'https://www.youtube-nocookie.com/embed/' + videoId + '?autoplay=1&rel=0&modestbranding=1&playsinline=1&fs=1';
                const vidSlide = document.createElement('div');
                vidSlide.className = 'carousel-item active position-relative';
                vidSlide.innerHTML = `
                    <div class="slide-wrap" style="position:relative;">
                        <iframe id="modalVideoIframe"
                            src="${embedUrl}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                            allowfullscreen
                            sandbox="allow-scripts allow-same-origin allow-presentation allow-popups allow-forms"
                            style="width:100%;height:380px;background:#000;display:block;">
                        </iframe>
                        <div style="position:absolute;bottom:8px;right:12px;">
                            <a href="${youtubeWatchUrl}" target="_blank" style="color:#ccc;font-size:11px;text-decoration:none;background:rgba(0,0,0,0.6);padding:3px 8px;border-radius:4px;">
                                ▶ Watch on YouTube
                            </a>
                        </div>
                    </div>`;
                inner.appendChild(vidSlide);
            } else {
                // Local video file — embed directly
                const vidSlide = document.createElement('div');
                vidSlide.className = 'carousel-item active position-relative';
                vidSlide.innerHTML = '<div class="slide-wrap"><video id="modalVideo" src="' + videoUrl + '" controls playsinline preload="metadata" style="max-height:340px;max-width:100%;width:100%;object-fit:contain;background:#000;" autoplay></video></div>';
                inner.appendChild(vidSlide);
            }

            // Slide 1: IMAGE
            const imgSlide = document.createElement('div');
            imgSlide.className = 'carousel-item position-relative';
            imgSlide.innerHTML = '<div class="slide-wrap"><img src="' + imageUrl + '" alt="' + name.replace(/"/g, '&quot;') + '"></div>';
            inner.appendChild(imgSlide);

            // Show nav controls
            indicators.classList.remove('d-none');
            prevBtn.classList.remove('d-none');
            nextBtn.classList.remove('d-none');

            // Pause local video on slide change
            carouselEl.addEventListener('slid.bs.carousel', function(e) {
                var vid = document.getElementById('modalVideo');
                if (e.to === 0) {
                    if (vid) vid.play().catch(function(){});
                } else {
                    if (vid) vid.pause();
                }
            });

        } else {
            // No video — only image slide
            const imgSlide = document.createElement('div');
            imgSlide.className = 'carousel-item active position-relative';
            imgSlide.innerHTML = '<div class="slide-wrap"><img src="' + imageUrl + '" alt="' + name.replace(/"/g, '&quot;') + '"></div>';
            inner.appendChild(imgSlide);

            // Hide nav controls
            indicators.classList.add('d-none');
            prevBtn.classList.add('d-none');
            nextBtn.classList.add('d-none');
        }

        // Reset to slide 0
        const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl, { ride: false, wrap: true, touch: true });
        bsCarousel.to(0);

        // Stop video/iframe when modal closes
        const modalEl = document.getElementById('productModal');
        modalEl.addEventListener('hidden.bs.modal', function stopOnClose() {
            var vid = document.getElementById('modalVideo');
            if (vid) { vid.pause(); vid.currentTime = 0; }
            var fr = document.getElementById('modalVideoIframe');
            if (fr) fr.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            modalEl.removeEventListener('hidden.bs.modal', stopOnClose);
        });

        // Show modal
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    // Client-side Product Live Search Filter
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('productSearchInput');
        const clearBtn = document.getElementById('clearSearchBtn');
        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase().trim();
            
            if (query.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }

            // Loop through each category table and row
            const headers = document.querySelectorAll('.category-header');
            headers.forEach(header => {
                const tableContainer = header.nextElementSibling;
                if (!tableContainer || !tableContainer.classList.contains('table-responsive')) return;

                const rows = tableContainer.querySelectorAll('.product-row');
                let visibleRowsCount = 0;

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                        visibleRowsCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (visibleRowsCount > 0) {
                    header.style.display = '';
                    tableContainer.style.display = '';
                } else {
                    header.style.display = 'none';
                    tableContainer.style.display = 'none';
                }
            });
        });

        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        });
    });
    </script>

@endsection
