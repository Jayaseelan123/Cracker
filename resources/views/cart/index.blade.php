@extends('layouts.front')

@section('title', 'Shopping Cart')
@section('hero_title', 'Your Shopping Cart')
@section('hero_subtitle', 'Review and checkout')

@section('content')
    @if (count($cart) > 0)
        @php $cartTotal = 0; @endphp
        <style>
            .cart-item-card { display: flex; gap: 12px; align-items: center; padding: 12px; }
            .cart-item-card .thumb { width: 110px; flex: 0 0 110px; }
            .cart-item-card .thumb img { width: 100%; height: 90px; object-fit: cover; border-radius: 8px; }
            .cart-item-details { flex: 1; }
            .cart-item-actions { width: 220px; flex: 0 0 220px; text-align: right; }
            .cart-summary { position: sticky; top: 80px; }
            .empty-cart-msg { display: none; }
            .empty-cart-msg.show { display: block; }
        </style>

        <div class="row">
            <div class="col-12 col-md-8" id="cart-items-container">
                @foreach($cart as $productId => $quantity)
                    @php $product = \App\Models\Product::find($productId); @endphp
                    @if($product)
                        @php
                            $price = $product->price ?? 0;
                            $orig = $product->mrp ?? $product->rate ?? $price;
                            $itemTotal = $price * $quantity;
                            $cartTotal += $itemTotal;
                            $itemSave = ($orig > $price) ? ($orig - $price) * $quantity : 0;
                        @endphp

                        <div class="card mb-3 cart-item-product-{{ $productId }}">
                            <div class="card-body cart-item-card">
                                <div class="thumb">
                                    @if($product->image)
                                        <img src="{{ asset('product_images/' . $product->image) }}" alt="{{ $product->name_en ?? $product->name }}">
                                    @else
                                        <img src="{{ asset('images/placeholder.png') }}" alt="{{ $product->name_en ?? $product->name }}">
                                    @endif
                                </div>
                                <div class="cart-item-details">
                                    <h6 class="mb-1">{{ $product->name_en ?? $product->name ?? '—' }}</h6>
                                    @if(!empty($product->name_ta))
                                        <div class="text-muted small">{{ $product->name_ta }}</div>
                                    @endif
                                    <div class="text-muted small">{{ $product->pack_size ?? '' }}</div>
                                    <div class="mt-2 fw-bold">Price: ₹{{ number_format($price, 2) }}</div>
                                </div>
                                <div class="cart-item-actions">
                                    <div class="d-flex justify-content-end mb-2">
                                        <button type="button" data-id="{{ $product->id }}" class="qty-btn minus cart-minus-btn" aria-label="Decrease">-</button>
                                        <input type="text" readonly class="qty-input cart-qty-{{ $product->id }}" value="{{ $quantity }}">
                                        <button type="button" data-id="{{ $product->id }}" class="qty-btn plus cart-plus-btn" aria-label="Increase">+</button>
                                    </div>

                                    <div class="mb-2">Total: <strong class="new-price cart-item-total-{{ $product->id }}">₹{{ number_format($itemTotal, 2) }}</strong></div>
                                    <button type="button" data-id="{{ $product->id }}" class="btn btn-success btn-sm cart-remove-btn">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="col-12 col-md-4">
                <div class="card cart-summary">
                    <div class="card-body">
                        <h5 class="mb-3">Total Price: <strong id="cart-total-price">₹{{ number_format($cartTotal, 2) }}</strong></h5>
                        @php $itemsCount = array_sum($cart); $totalSave = 0; foreach($cart as $pid => $q){ $p = \App\Models\Product::find($pid); if($p){ $origp = $p->mrp ?? $p->rate ?? $p->price ?? 0; $totalSave += max(0, ($origp - ($p->price ?? 0)) * $q); }} @endphp
                        <p class="mb-1">Number of Items: <strong id="cart-items-count">{{ $itemsCount }}</strong></p>
                        <p class="mb-3">You Save: <strong id="cart-total-save">₹{{ number_format($totalSave, 2) }}</strong></p>
                        <a href="{{ route('checkout') }}" class="btn" style="background:#ff9800;color:#fff;display:block;padding:12px;border-radius:8px;">Proceed to Checkout</a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-3 d-block">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <div class="alert alert-info text-center py-5 empty-cart-msg @if(count($cart) == 0) show @endif">
        <h5>Your cart is empty</h5>
        <p>Start adding products to your cart.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
@endsection

@push('scripts')
<script>
    // Real-time cart update functions
    function updateCartDisplay() {
        recalculateCartTotals();
        updateCartBadge();
        refreshCartDrawer();
    }

    function recalculateCartTotals() {
        let totalPrice = 0;
        let totalItems = 0;
        let totalSave = 0;

        // Get all quantity inputs
        document.querySelectorAll('[class*="cart-qty-"]').forEach(input => {
            const qty = parseInt(input.value) || 0;
            const productId = input.className.match(/cart-qty-(\d+)/)?.[1];
            
            if (productId && qty > 0) {
                totalItems += qty;
                
                // Get product data from the card
                const card = document.querySelector('.cart-item-product-' + productId);
                if (card) {
                    const priceText = card.querySelector('.fw-bold:not(.new-price)')?.textContent || '';
                    const priceMatch = priceText.match(/₹([\d,.]+)/);
                    const price = priceMatch ? parseFloat(priceMatch[1].replace(/,/g, '')) : 0;
                    const itemTotal = price * qty;
                    totalPrice += itemTotal;
                    
                    // Update item total
                    const totalSpan = card.querySelector('.cart-item-total-' + productId);
                    if (totalSpan) {
                        totalSpan.textContent = '₹' + itemTotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            }
        });

        // Update summary
        const totalPriceEl = document.getElementById('cart-total-price');
        const itemsCountEl = document.getElementById('cart-items-count');
        const totalSaveEl = document.getElementById('cart-total-save');
        
        if (totalPriceEl) totalPriceEl.textContent = '₹' + totalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        if (itemsCountEl) itemsCountEl.textContent = totalItems;
        if (totalSaveEl) totalSaveEl.textContent = '₹' + totalSave.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        
        // Show/hide empty cart message
        const emptyMsg = document.querySelector('.empty-cart-msg');
        const cartContainer = document.getElementById('cart-items-container');
        if (totalItems === 0) {
            if (emptyMsg) emptyMsg.classList.add('show');
            if (cartContainer) cartContainer.style.display = 'none';
        } else {
            if (emptyMsg) emptyMsg.classList.remove('show');
            if (cartContainer) cartContainer.style.display = 'block';
        }
    }

    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            let total = 0;
            document.querySelectorAll('[class*="cart-qty-"]').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            badge.textContent = total;
        }
    }

    function refreshCartDrawer() {
        const partialUrl = '{{ route("cart.view.partial") }}';
        const panel = document.getElementById('rightCartPanel');
        if (!panel) return;
        
        fetch(partialUrl)
            .then(res => res.text())
            .then(html => {
                panel.innerHTML = html;
            })
            .catch(err => console.error('Failed to refresh cart drawer', err));
    }

    // Plus button - Add to cart
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('cart-plus-btn')) {
            e.preventDefault();
            const productId = e.target.getAttribute('data-id');
            const qtyInput = document.querySelector('.cart-qty-' + productId);
            const currentQty = parseInt(qtyInput.value) || 0;
            const newQty = currentQty + 1;
            
            // Optimistic update
            qtyInput.value = newQty;
            
            fetch('/cart/ajax/add/' + productId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateCartDisplay();
            })
            .catch(error => {
                console.error('Error:', error);
                qtyInput.value = currentQty;
            });
        }
    });

    // Minus button - Decrease quantity
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('cart-minus-btn')) {
            e.preventDefault();
            const productId = e.target.getAttribute('data-id');
            const qtyInput = document.querySelector('.cart-qty-' + productId);
            const currentQty = parseInt(qtyInput.value) || 0;
            const newQty = Math.max(0, currentQty - 1);
            
            // Optimistic update
            qtyInput.value = newQty;
            
            if (newQty === 0) {
                // Remove item from DOM
                const cartItem = document.querySelector('.cart-item-product-' + productId);
                if (cartItem) cartItem.remove();
            }
            
            fetch('/cart/ajax/update/' + productId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(response => response.json())
            .then(data => {
                updateCartDisplay();
            })
            .catch(error => {
                console.error('Error:', error);
                qtyInput.value = currentQty;
                if (newQty === 0) {
                    location.reload();
                }
            });
        }
    });

    // Remove button
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('cart-remove-btn')) {
            e.preventDefault();
            const productId = e.target.getAttribute('data-id');
            const cartItem = document.querySelector('.cart-item-product-' + productId);
            
            // Remove from DOM
            if (cartItem) cartItem.remove();
            
            fetch('/cart/ajax/remove/' + productId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateCartDisplay();
            })
            .catch(error => {
                console.error('Error:', error);
                location.reload();
            });
        }
    });

    // Initial calculation on page load
    recalculateCartTotals();
</script>
@endpush
