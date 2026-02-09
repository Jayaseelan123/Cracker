@extends('layouts.front')

@section('title', 'Checkout & Cart')
@section('hero_title', 'Checkout')
@section('hero_subtitle', '')

@section('content')

<style>
    .cart-card-item { display:flex; gap:12px; align-items:center; padding:12px; }
    .cart-card-item .thumb { width:100px; flex:0 0 100px; }
    .cart-card-item .thumb img { width:100%; height:80px; object-fit:cover; border-radius:8px; }
    .cart-card-item .details { flex:1; }
    .cart-card-item .actions { width:220px; flex:0 0 220px; text-align:right; }
</style>

<div class="row">

    <!-- LEFT SIDE — ALWAYS VISIBLE CART ITEMS -->
    <div class="col-12 col-md-8">
        @if(count($items) > 0)
            @foreach($items as $it)
                @php
                    $product = $it['product'];
                    $qty = $it['qty'];
                    $price = $product->price ?? $product->rate ?? $product->mrp ?? 0;
                    $itemTotal = $price * $qty;
                @endphp

                <div class="card mb-3">
                    <div class="card-body cart-card-item">
                        <div class="thumb">
                            <img src="{{ asset('product_images/' . ($product->image_path ?? $product->image)) }}"
                                 alt="{{ $product->name_en ?? $product->name }}"
                                 onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        </div>

                        <div class="details">
                            <h6 class="mb-1">{{ $product->name_en ?? $product->name }}</h6>
                            <div class="text-muted small">{{ $product->pack_size ?? '' }}</div>
                            <div class="mt-2 fw-bold">₹{{ number_format($price, 2) }}</div>
                        </div>

                        <div class="actions">
                            <div class="d-flex justify-content-end mb-2">
                                <form action="{{ route('cart.update', $product->id) }}" method="post" class="me-2">
                                    @csrf
                                    <input type="hidden" name="quantity" value="{{ max(0, $qty - 1) }}">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">-</button>
                                </form>

                                <input type="text" readonly class="qty-input" value="{{ $qty }}"
                                       style="width:56px; text-align:center;">

                                <form action="{{ route('cart.add', $product->id) }}" method="post" class="ms-2">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                                </form>
                            </div>

                            <div class="mb-2">Total:
                                <strong>₹{{ number_format($itemTotal, 2) }}</strong>
                            </div>

                            <form action="{{ route('cart.remove', $product->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach
        @else
            <div class="alert alert-info">Your cart is empty.</div>
        @endif
         <div class="card">
            <div class="card-body">
                <h4>Order Summary</h4>

                @if(count($items) == 0)
                    <p>Your cart is empty.</p>
                @else
                    @foreach($items as $it)
                        <div class="d-flex align-items-center mb-3">
                            <div style="width:48px;height:48px;overflow:hidden;border-radius:6px;">
                                <img src="{{ asset('product_images/' . ($it['product']->image_path ?? $it['product']->image)) }}"
                                     style="width:100%;height:100%;object-fit:cover;">
                            </div>

                            <div class="ms-3 flex-grow-1">
                                <div>{{ $it['product']->name_en ?? $it['product']->name }}</div>
                                <small class="text-muted">Qty: {{ $it['qty'] }}</small>
                            </div>

                            <div class="text-end">₹{{ number_format($it['total'], 2) }}</div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Packing Charge</span>
                        <span>₹{{ number_format($packing, 2) }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total Amount</strong>
                        <strong class="text-primary fs-4">₹{{ number_format($total, 2) }}</strong>
                    </div>

                @endif

            </div>
        </div>
    </div>
    

    <!-- RIGHT SIDE — ALWAYS VISIBLE SHIPPING + SUMMARY -->
    <div class="col-12 col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h4>Shipping Information</h4>

                <form method="post" action="{{ route('checkout.place') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="10-digit mobile">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email (Optional)</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Address *</label>
                        <textarea name="address" rows="3"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City *</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                   class="form-control @error('city') is-invalid @enderror">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">State *</label>
                            <input type="text" name="state" value="{{ old('state') }}"
                                   class="form-control @error('state') is-invalid @enderror">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">PIN Code</label>
                            <input type="text" name="pin" value="{{ old('pin') }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nearby Location</label>
                        <input type="text" name="nearby" value="{{ old('nearby') }}" class="form-control">
                    </div>

                    <button class="btn btn-primary btn-lg w-100">Place Order</button>

                </form>
            </div>
        </div>

        

    </div>

</div>

@endsection
