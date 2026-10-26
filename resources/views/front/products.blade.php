@extends('layouts.app')

@php
    $__catMeta = include resource_path('seo/categories.php');
    $__catSlug = request()->query('category');
    $__seo = $__catMeta[$__catSlug] ?? null;
@endphp

@if($__seo)
    @section('title', $__seo['t'])
    @section('meta_description', $__seo['d'])
    @section('og_title', $__seo['o'])
    @section('canonical', 'https://kasthuripyro.com/?category=' . $__catSlug)
@else
    @section('title', 'Best Crackers Shop in Sivakasi | Kasthuri Crackers')
    @section('meta_description', 'Kasthuri Crackers is the best crackers shop in Sivakasi. Buy Sivakasi crackers online at wholesale price with fast, safe delivery across India. Shop now!')
    @section('og_title', 'Best Crackers Shop in Sivakasi | Kasthuri Crackers')
    @section('canonical', 'https://kasthuripyro.com/')
@endif

@section('hero_title', 'Explore Our Collection')
@section('hero_subtitle', 'Discover a wide range of quality products for every celebration')

@section('content')

    <style>
        .offer-price {
            display: inline-block;
            font-weight: 800;
            font-size: 1.25em;
            color: #198754;
            animation: offerBlink 1.2s infinite;
        }

        @keyframes offerBlink {
            0%,
            100% {
                color: #198754;
                opacity: 1;
            }
            50% {
                color: #32cd32;
                opacity: 1;
            }
        }

        /* Responsive Products Page CSS */
        body {
            overflow-x: hidden;
            /* Prevent horizontal scroll on the entire body */
        }

        .responsive-th {
            white-space: nowrap;
            font-size: 20px;
        }

        @media (max-width: 991px) {
            .responsive-th {
                font-size: 16px;
            }

            .mobile-td-id {
                font-size: 16px !important;
            }
        }

        @media (max-width: 767px) {
            .table-responsive {
                border: none !important;
            }

            .product-table th, .product-table td {
                padding: 4px 2px !important;
                font-size: 11px !important;
            }

            .mobile-td-img img {
                width: 45px !important;
                height: 45px !important;
                object-fit: cover !important;
            }
            
            .mobile-td-name > div {
                font-size: 11px !important;
            }

            .mobile-td-mrp > div {
                font-size: 12px !important;
                padding: 1px 4px !important;
                margin-top: 0 !important;
                white-space: nowrap !important;
            }

            .mobile-td-price > span {
                font-size: 14px !important;
                padding: 0 !important;
                margin-top: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
            }

            .qty-controls {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 2px !important;
                margin: 0;
            }

            .qty-btn {
                width: 24px !important;
                height: 24px !important;
                font-size: 14px !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
            }

            .qty-input {
                width: 32px !important;
                height: 24px !important;
                font-size: 12px !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Ensure no horizontal scrollbar from containers */
            .container,
            .container-fluid {
                max-width: 100%;
                overflow-x: hidden;
            }

            .category-header {
                font-size: 14px;
                padding: 6px;
                margin: 10px 0;
                text-align: center;
            }

            h2.section-title {
                font-size: 20px;
            }

            /* Make search input fully responsive */
            .search-filter-container {
                width: 100%;
                padding: 0 15px;
            }
        }

        /* Smaller mobile screens specifically 375px and 320px */
        @media (max-width: 390px) {
            .product-table,
            .table-responsive {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                overflow-x: auto !important;
            }

            .product-table th {
                font-size: 9px !important;
                padding: 2px 1px !important;
                white-space: normal !important;
                word-wrap: break-word;
            }

            .product-table td {
                padding: 2px 1px !important;
                font-size: 9px !important;
            }

            .mobile-td-img {
                width: 35px !important;
                padding: 1px !important;
            }

            .mobile-td-img img {
                width: 30px !important;
                height: 30px !important;
                object-fit: cover !important;
            }

            .mobile-td-name > div {
                font-size: 9px !important;
                white-space: normal !important;
                word-wrap: break-word;
            }

            .mobile-td-mrp > div {
                font-size: 9px !important;
                padding: 1px !important;
            }

            .mobile-td-price > span {
                font-size: 9px !important;
                padding: 0 !important;
            }

            .qty-controls {
                gap: 1px !important;
            }

            .qty-btn {
                width: 18px !important;
                height: 18px !important;
                font-size: 10px !important;
                padding: 0 !important;
            }

            .qty-input {
                width: 20px !important;
                height: 18px !important;
                font-size: 9px !important;
                padding: 0 !important;
            }
        }
    </style>

    <!-- PRODUCTS SECTION START -->
    @if(\App\Models\SiteSetting::bool('show_pricelist_home', true))
        <div id="products-list" class="text-center mb-5 mt-5" style="scroll-margin-top: 80px;">
            <h2 class="section-title">Browse Our Collection</h2>
            <div class="title-underline"></div>
            <p class="text-muted mt-2">Explore our premium range and choose your favourites</p>
        </div>
        <div class="search-filter-container container mb-5" style="max-width: 620px;">
            <div class="input-group shadow rounded-pill overflow-hidden" style="background:#fff; border: 2px solid #0a4f68;"
                id="productSearchBox">

                <span class="input-group-text bg-white border-0 ps-3">
                    <i class="fas fa-search" style="color:#0a4f68;"></i>
                </span>

                <input type="text" id="productSearchInput" class="form-control border-0 py-3 ps-2"
                    placeholder="Search products, enter quantity and add to cart..." style="outline:none; box-shadow:none; font-size:1rem;"
                    autocomplete="off">

                <button class="btn border-0 bg-white pe-3" type="button" id="clearSearchBtn"
                    style="display:none; color:#0a4f68;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>



        <div class="table-responsive container mb-5" style="border: 1px solid #ddd; border-radius: 4px; padding: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 1200px; margin: 0 auto;">
            <table class="table table-bordered product-table mb-0" style="background-color: #FAF9F6; width: 100%; border-collapse: collapse; table-layout: auto;">
                <thead style="background-color: #ea9708; color: #0f0e0eff;">
                    <tr>
                        <th class="text-center" style="font-weight: bold; padding: 12px; font-size: 16px;background-color: #ff9800;">Image</th>
                        <th class="text-center" style="font-weight: bold; padding: 12px; font-size: 16px;background-color: #ff9800;">Product</th>
                        @if(\App\Models\SiteSetting::bool('show_discount_row', true))
                            <th class="text-center" style="font-weight: bold; padding: 12px; font-size: 16px;background-color: #ff9800;">MRP</th>
                        @endif
                        <th class="text-center" style="font-weight: bold; padding: 12px; font-size: 16px;background-color: #ff9800;">Offer Price</th>
                        <th class="text-center" style="font-weight: bold; padding: 12px; font-size: 16px;background-color: #ff9800;">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="category-row" id="cat-{{ $category->slug ?? Str::slug($category->name) }}">
                            <td colspan="{{ \App\Models\SiteSetting::bool('show_discount_row', true) ? 5 : 4 }}" style="background-color: #4da2d6ff; color: white; text-align: center; font-weight: bold; text-transform: uppercase; padding: 8px; border: none; font-size: 16px; letter-spacing: 0.5px;">
                                {{ $category->name }}
                            </td>
                        </tr>
                        @forelse($category->products as $product)
                            @php
                                $productImg = asset('product_images/' . ($product->image_path ?: $product->image ?: 'demo.jpg'));
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
                                $productName = addslashes($product->name_en ?? $product->name ?? '');
                                $productTa = addslashes($product->name_ta ?? '');
                                $productMrp = number_format($product->mrp, 0);
                                $productPrice = number_format($product->price, 0);
                            @endphp
                            <tr class="product-row" style="background-color: #FAF9F6; border-bottom: 1px solid #e0e0e0;">
                                <td class="mobile-td-img" style="text-align:center; vertical-align: middle; padding: 10px; width: 100px;">
                                    @if($vid)
                                        <div style="position:relative;display:inline-block;cursor:pointer;"
                                            onclick="openPreviewModal('{{ $productName }}', '{{ $productImg }}', '{{ $productVideo }}')">
                                            <img src="{{ $productImg }}" alt="{{ $product->name_en ?? $product->name }}"
                                              style="border-radius:4px; width:60px; height:60px; object-fit:cover; box-shadow: 0 1px 3px rgba(0,0,0,0.2);">
                                            <span
                                                style="position:absolute;bottom:3px;right:3px;background:rgba(0,0,0,0.6);border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-play" style="color:#fff;font-size:8px;margin-left:2px;"></i>
                                            </span>
                                        </div>
                                    @else
                                      <img src="{{ $productImg }}" alt="{{ $product->name_en ?? $product->name }}"
                                        style="cursor:pointer;border-radius:4px; width:60px; height:60px; object-fit:cover; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"
                                        onclick="openPreviewModal('{{ $productName }}', '{{ $productImg }}', '')">
                                    @endif
                                </td>

                                <td class="mobile-td-name" style="text-align:center; vertical-align: middle; padding: 10px;">
                                    @if(\App\Models\SiteSetting::bool('show_product_code', false) && !empty($product->sku))
                                        <div class="text-primary small fw-bold mb-1">Code: {{ $product->sku }}</div>
                                    @endif
                                    <div style="font-size:1.05rem; font-weight:700; color: #1a1a1a; margin-bottom: 2px;">
                                        {{ $product->name_en ?? $product->name ?? '—' }}</div>
                                    @if(!empty($product->content))
                                        <div style="font-size:0.85rem; color: #777; margin-bottom: 2px;">{{ $product->content }}</div>
                                    @endif
                                </td>

                                <!-- MRP -->
                                @if(\App\Models\SiteSetting::bool('show_discount_row', true))
                                    <td class="mobile-td-mrp" style="text-align:center; vertical-align: middle; padding: 10px;">
                                        <div style="font-weight: 700; font-size: 1.1rem; color: #D9534F; text-decoration: line-through; display: inline-block; background: #fff; padding: 2px 8px; border-radius: 4px;">
                                            &#8377; {{ number_format($product->mrp, 0) }}
                                        </div>
                                    </td>
                                @endif

                                <!-- Offer Price -->
                                <td class="mobile-td-price" style="text-align:center; vertical-align: middle; padding: 10px;">
                                <span class="offer-price">
                                    &#8377; {{ number_format($product->price, 0) }}
                                </span>
                            </td>

                                <!-- Quantity -->
                                @php $cartItems = session('cart', []);
                                $cartQty = $cartItems[$product->id] ?? 0; @endphp
                                <td class="mobile-td-qty" style="text-align:center; vertical-align: middle; padding: 10px;">
                                    <div class="qty-controls">
                                        <button type="button" data-id="{{ $product->id }}" class="qty-btn minus qty-minus-btn" style="background: #E74C3C; color: white; border: none;">-</button>
                                        <input type="text" readonly class="qty-input qty-display-{{ $product->id }}" value="{{ $cartQty }}" style="text-align: center; border: 1px solid #ddd; background: #fff;">
                                        <button type="button" data-id="{{ $product->id }}" class="qty-btn plus qty-plus-btn" style="background: #28A745; color: white; border: none;">+</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100" class="text-center py-3 text-muted">No products in this category.</td>
                            </tr>
                        @endforelse
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

   

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Mobile Amount Calculation
                function updateMobileGrandTotal() {
                    let total = 0;
                    document.querySelectorAll('.mobile-qty-input').forEach(inp => {
                        let q = parseInt(inp.value) || 0;
                        let p = parseFloat(inp.getAttribute('data-price')) || 0;
                        total += (q * p);
                    });
                    document.getElementById('mobile-grand-total').innerText = total.toFixed(2);
                }

                document.querySelectorAll('.mobile-qty-input').forEach(input => {
                    input.addEventListener('input', function() {
                        let qty = parseInt(this.value) || 0;
                        let price = parseFloat(this.getAttribute('data-price')) || 0;
                        let amt = qty * price;
                        document.getElementById('mobile-amt-' + this.getAttribute('data-id')).innerText = amt.toFixed(2);
                        updateMobileGrandTotal();
                    });
                });
                // Initial calculation on page load
                updateMobileGrandTotal();

                // ---- Scroll to category anchor on page load (from home category click) ----
                if (window.location.hash) {
                    const targetId = window.location.hash.substring(1); // e.g. "cat-fireworks"
                    const targetEl = document.getElementById(targetId);
                    if (targetEl) {
                        // Slight delay so the page fully renders before scrolling
                        setTimeout(function () {
                            const offset = 85; // Fixed header height + buffer
                            const top = targetEl.getBoundingClientRect().top + window.pageYOffset - offset;
                            window.scrollTo({ top: top, behavior: 'smooth' });
                            // Highlight the category header briefly
                            targetEl.style.transition = 'box-shadow 0.4s ease';
                            targetEl.style.boxShadow = '0 0 0 4px rgba(255,153,0,0.6)';
                            setTimeout(() => { targetEl.style.boxShadow = ''; }, 2000);
                        }, 300);
                    }
                }

                // ---- Product Search Filter ----
                const searchInput = document.getElementById('productSearchInput');
                const clearBtn = document.getElementById('clearSearchBtn');
                const allRows = document.querySelectorAll('tr.product-row');
                const categoryBlocks = document.querySelectorAll('.category-section-wrap');

                // Create "no results" message
                const noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noProductsMsg';
                noResultsMsg.className = 'text-center text-muted py-5';
                noResultsMsg.innerHTML = '<i class="fas fa-box-open fa-3x mb-3 d-block" style="color:#ccc;"></i><h5>No products found</h5><p>Try a different search term.</p>';
                noResultsMsg.style.display = 'none';
                const productsListDiv = document.getElementById('products-list');
                if (productsListDiv) productsListDiv.after(noResultsMsg);

                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const term = this.value.toLowerCase().trim();

                        // Toggle clear button
                        if (clearBtn) {
                            clearBtn.style.display = term.length > 0 ? '' : 'none';
                        }

                        let visibleTotal = 0;
                        let currentCategoryHeader = null;
                        let categoryVisibleCount = 0;

                        const allTableRows = document.querySelectorAll('table.product-table tbody tr');
                        allTableRows.forEach(function (row) {
                            if (row.classList.contains('category-row')) {
                                // If we had a previous category, hide it if count was 0
                                if (currentCategoryHeader && categoryVisibleCount === 0 && term !== '') {
                                    currentCategoryHeader.style.display = 'none';
                                } else if (currentCategoryHeader) {
                                    currentCategoryHeader.style.display = '';
                                }

                                currentCategoryHeader = row;
                                categoryVisibleCount = 0;
                            } else if (row.classList.contains('product-row')) {
                                const nameCell = row.querySelector('.mobile-td-name');
                                const text = nameCell ? nameCell.innerText.toLowerCase() : row.innerText.toLowerCase();
                                
                                if (term === '' || text.includes(term)) {
                                    row.style.display = '';
                                    categoryVisibleCount++;
                                    visibleTotal++;
                                } else {
                                    row.style.display = 'none';
                                }
                            }
                        });

                        // Handle the last category
                        if (currentCategoryHeader && categoryVisibleCount === 0 && term !== '') {
                            currentCategoryHeader.style.display = 'none';
                        } else if (currentCategoryHeader) {
                            currentCategoryHeader.style.display = '';
                        }

                        // Global no-results message
                        noResultsMsg.style.display = (visibleTotal === 0 && term !== '') ? 'block' : 'none';
                    });

                    // Clear button
                    if (clearBtn) {
                        clearBtn.addEventListener('click', function () {
                            searchInput.value = '';
                            searchInput.dispatchEvent(new Event('input'));
                            searchInput.focus();
                        });
                    }
                }
            });

            // Product Preview Modal using SweetAlert2
            function openPreviewModal(name, imageSrc, videoSrc) {
                let hasVideo = (videoSrc && videoSrc.trim() !== '');

                // Container with horizontal scroll
                let htmlContent = `
                    <style>
                        /* Custom scrollbar for preview */
                        .preview-scroll-container::-webkit-scrollbar {
                            height: 6px;
                        }
                        .preview-scroll-container::-webkit-scrollbar-track {
                            background: #f1f1f1;
                            border-radius: 10px;
                        }
                        .preview-scroll-container::-webkit-scrollbar-thumb {
                            background: #0a4f68;
                            border-radius: 10px;
                        }
                        .preview-item {
                            min-width: 100%;
                            flex: 0 0 100%;
                            scroll-snap-align: center;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                    </style>`;

                if (hasVideo) {
                    htmlContent += `<div style="font-size: 13px; color: #666; margin-bottom: 10px; animation: pulse 2s infinite;">
                                            <i class="fas fa-arrows-alt-h me-1"></i> Swipe or scroll horizontally to see video
                                        </div>`;
                }

                htmlContent += `<div class="preview-scroll-container" style="display: flex; overflow-x: auto; overflow-y: hidden; scroll-snap-type: x mandatory; gap: 10px; padding-bottom: 15px; align-items: center; -webkit-overflow-scrolling: touch;">`;

                // Always show the image first
                htmlContent += `<div class="preview-item">
                                        <img src="${imageSrc}" style="width:100%; max-height:60vh; border-radius:8px; object-fit:contain; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    </div>`;

                // If there's a video, show it horizontally next to the image
                if (hasVideo) {
                    // Determine if it's a YouTube URL or a direct video file
                    if (videoSrc.includes('youtube.com') || videoSrc.includes('youtu.be')) {
                        // Extract video ID and use embed URL
                        let videoId = '';
                        if (videoSrc.includes('youtu.be/')) {
                            videoId = videoSrc.split('youtu.be/')[1].split('?')[0];
                        } else if (videoSrc.includes('v=')) {
                            videoId = videoSrc.split('v=')[1].split('&')[0];
                        } else if (videoSrc.includes('/embed/')) {
                            videoId = videoSrc.split('/embed/')[1].split('?')[0];
                        } else if (videoSrc.includes('/shorts/')) {
                            videoId = videoSrc.split('/shorts/')[1].split('?')[0];
                        }

                        if (videoId) {
                            htmlContent += `<div class="preview-item">
                                                    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;width:100%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                                        <iframe src="https://www.youtube.com/embed/${videoId}?autoplay=0" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                    </div>
                                                </div>`;
                        }
                    } else if (videoSrc.endsWith('.mp4') || videoSrc.endsWith('.webm') || videoSrc.endsWith('.ogg') || videoSrc.includes('product_videos/')) {
                        htmlContent += `<div class="preview-item">
                                                <video width="100%" controls style="border-radius:8px; max-height:60vh; aspect-ratio: 16/9; background: #000; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                                    <source src="${videoSrc}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>`;
                    } else {
                        // For generic video links, try iframe
                        htmlContent += `<div class="preview-item">
                                                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;width:100%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                                    <iframe src="${videoSrc}" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                </div>
                                            </div>`;
                    }
                }

                htmlContent += `</div>`;

                Swal.fire({
                    title: `<h4 style="margin:0;font-weight:600;color:#0a4f68;font-size:clamp(1rem, 4vw, 1.25rem);">${name}</h4>`,
                    html: htmlContent,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '600px',
                    padding: '1.5em',
                });
            }
        </script>
    @endpush
@endsection