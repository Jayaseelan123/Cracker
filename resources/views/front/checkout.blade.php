@extends('layouts.front')

@section('title', 'Finalize Your Enquiry')
@section('hero_title', 'Complete Your Enquiry')
@section('hero_subtitle', 'Provide your details to receive a final quote')

@section('content')

<div class="row g-4 py-5">
    <!-- LEFT SIDE: CART REVIEW -->
    <div class="col-lg-7">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: bold;">1</div>
            <h4 class="mb-0 fw-bold">Review Selected Items</h4>
        </div>

        @forelse($items as $it)
            @php
                $product = $it['product'];
                $qty = $it['qty'];
                $price = $product->price ?? $product->rate ?? $product->mrp ?? 0;
                $itemTotal = $price * $qty;
            @endphp
            <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden product-card-hover">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="rounded-3 overflow-hidden" style="width: 80px; height: 80px;">
                                <img src="{{ asset('product_images/' . ($product->image_path ?? $product->image)) }}"
                                     alt="{{ $product->name_en ?? $product->name }}"
                                     class="w-100 h-100 object-fit-cover"
                                     onerror="this.src='{{ asset('images/placeholder.png') }}'">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold mb-1">{{ $product->name_en ?? $product->name }}</h6>
                            <div class="text-muted small mb-2">{{ $product->pack_size ?? 'Standard Pack' }}</div>
                            <div class="fw-bold text-primary">₹{{ number_format($price, 2) }}</div>
                        </div>
                        <div class="col-md-auto mt-3 mt-md-0">
                            <div class="d-flex align-items-center justify-content-md-end gap-3">
                                <div class="d-flex align-items-center bg-light rounded-pill p-1">
                                    <form action="{{ route('cart.update', $product->id) }}" method="post" class="m-0">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ max(0, $qty - 1) }}">
                                        <button type="submit" class="btn btn-sm btn-white rounded-circle shadow-sm" style="width: 28px; height: 28px; padding: 0;">-</button>
                                    </form>
                                    <span class="px-3 fw-bold">{{ $qty }}</span>
                                    <form action="{{ route('cart.add', $product->id) }}" method="post" class="m-0">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-white rounded-circle shadow-sm" style="width: 28px; height: 28px; padding: 0;">+</button>
                                    </form>
                                </div>
                                <div class="text-end min-w-100">
                                    <div class="small text-muted">Total</div>
                                    <div class="fw-bold">₹{{ number_format($itemTotal, 2) }}</div>
                                </div>
                                <form action="{{ route('cart.remove', $product->id) }}" method="post" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger p-0 ms-2" title="Remove">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="fas fa-shopping-basket fa-4x text-muted opacity-25 mb-3"></i>
                <h5>Your cart is empty</h5>
                <p class="text-muted">Explore our catalog to add items to your enquiry.</p>
                <a href="{{ url('/') }}" class="btn btn-primary px-4 rounded-pill mt-2">Browse Products</a>
            </div>
        @endforelse

        @if(count($items) > 0)
        <div class="card border-0 shadow-sm rounded-4 mt-4 bg-light bg-opacity-50">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Items Subtotal</span>
                    <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                    <span class="text-muted">Packing & Handling</span>
                    <span class="fw-bold">₹{{ number_format($packing, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Est. Total Amount</h5>
                    <h4 class="mb-0 fw-bold text-primary">₹{{ number_format($total, 2) }}</h4>
                </div>
                <div class="mt-2 small text-muted text-end">* Final pricing may vary based on delivery location</div>
            </div>
        </div>
        @endif
    </div>

    <!-- RIGHT SIDE: ENQUIRY FORM -->
    <div class="col-lg-5">
        <div class="sticky-top" style="top: 100px; z-index: 5;">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: bold;">2</div>
                <h4 class="mb-0 fw-bold">Your Information</h4>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-xl-5">
                    <form method="post" action="{{ route('checkout.place') }}" id="enquiryForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="Enter your full name" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-7">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Mobile Number *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">+91</span>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="form-control form-control-lg border-start-0 @error('phone') is-invalid @enderror"
                                           placeholder="10-digit number" required>
                                </div>
                                @error('phone') <div class="small text-danger mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">PIN Code</label>
                                <input type="text" name="pin" value="{{ old('pin') }}" 
                                       class="form-control form-control-lg" placeholder="6 digits">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Shipping Address *</label>
                            <textarea name="address" rows="3"
                                      class="form-control form-control-lg @error('address') is-invalid @enderror" 
                                      placeholder="House No, Street, Landmark..." required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">City/Town *</label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                       class="form-control @error('city') is-invalid @enderror" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">State *</label>
                                <input type="text" name="state" value="{{ old('state') ?? 'Tamil Nadu' }}"
                                       class="form-control @error('state') is-invalid @enderror" required>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Email (Optional)</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="form-control" placeholder="your@email.com">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-pill shadow hover-float" 
                                @if(count($items) == 0) disabled @endif>
                            SUBMIT ENQUIRY <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                        
                        <div class="text-center mt-3 text-muted small">
                            <i class="fas fa-lock me-1"></i> Your data is safe with us
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-white rounded-4 shadow-sm border-start border-4 border-warning">
                <div class="d-flex align-items-center">
                    <div class="text-warning me-3"><i class="fas fa-info-circle fa-2x"></i></div>
                    <div>
                        <div class="fw-bold">How it works?</div>
                        <div class="small text-muted">Submit this enquiry and our team will call you within 24 hours to confirm stock and final shipping price.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card-hover {
        transition: all 0.3s ease;
        border: 1px solid transparent !important;
    }
    .product-card-hover:hover {
        transform: translateX(5px);
        border-color: rgba(99, 102, 241, 0.2) !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .hover-float:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4) !important;
    }
    .form-control-lg {
        padding: 0.8rem 1.2rem;
        font-size: 1rem;
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }
    .form-control-lg:focus {
        background-color: #fff;
    }
    .btn-white {
        background-color: #fff;
        border-color: #e2e8f0;
        color: #334155;
    }
    .tracking-wider {
        letter-spacing: 0.05em;
    }
    .min-w-100 {
        min-width: 100px;
    }
</style>

@endsection

