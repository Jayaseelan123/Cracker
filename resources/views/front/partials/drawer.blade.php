<div class="panel-header mb-3">
    <span>Your Cart</span>
    <button class="close-btn" id="closeCartPanelPartial">&times;</button>
</div>

@if(count($cart) == 0)
    <div class="alert alert-info">Your cart is empty.</div>
@else
    <div class="list-group">
        @foreach($cart as $productId => $qty)
            @php
                $product = \App\Models\Product::find($productId);
                if (! $product) continue;

                $name = $product->name_en ?? $product->name ?? $product->title ?? 'Product';
                $name_ta = $product->name_ta ?? $product->tamil_name ?? '';
                $img = $product->image ?? $product->image_path ?? $product->photo ?? $product->img ?? null;
                if ($img && file_exists(public_path('product_images/' . $img))) {
                    $imageUrl = asset('product_images/' . $img);
                } elseif ($img && file_exists(public_path('images/' . $img))) {
                    $imageUrl = asset('images/' . $img);
                } else {
                    $imageUrl = asset('images/placeholder.png');
                }

                $mrp = $product->mrp ?? $product->rate ?? $product->price ?? 0;
                $price = $product->price ?? 0;
                $itemTotal = $price * $qty;
            @endphp

            <div class="card mb-2">
                <div class="card-body d-flex align-items-center gap-2">
                    <div style="flex:0 0 60px">
                        <img src="{{ $imageUrl }}" class="cart-thumb" alt="{{ $name }}">
                    </div>

                    <div style="flex:1">
                        <div class="fw-bold">{{ $name }}</div>
                        @if(!empty($name_ta))
                            <div class="text-muted small">{{ $name_ta }}</div>
                        @endif
                        <div class="small text-muted">Pack: {{ $product->pack_size ?? '-' }}</div>
                        <div class="mt-1 fw-bold text-success">₹{{ number_format($price,2) }}</div>
                    </div>

                    <div style="flex:0 0 140px; text-align:right">
                        <div class="d-flex gap-1 justify-content-end mb-2">
                            <button type="button" class="btn btn-danger btn-sm qty-minus"
                                data-id="{{ $product->id }}"
                                data-qty="{{ $qty }}">-</button>

                            <input type="text" readonly value="{{ $qty }}" 
                               class="form-control text-center qty-box-{{ $product->id }}"
                               style="width:40px;">

                            <button type="button" class="btn btn-success btn-sm qty-plus"
                                data-id="{{ $product->id }}">+</button>
                        </div>

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <div>Total: <strong>₹{{ number_format($itemTotal,2) }}</strong></div>
                            <button type="button" class="btn btn-outline-danger btn-sm qty-remove" data-id="{{ $product->id }}">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('checkout') }}" class="btn btn-warning w-100 fw-bold mt-3">Proceed To Checkout</a>
@endif

<script>
// Close button inside partial (when loaded via AJAX)
document.getElementById('closeCartPanelPartial')?.addEventListener('click', function(){
    document.getElementById('rightCartPanel').classList.remove('open');
});
</script>
