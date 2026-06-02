@php
    use App\Models\Product;
    use App\Models\DeliveryZone;

    $cartItems = [];
    $netTotal = 0;
    $discountTotal = 0;

    foreach ((array) $cart as $productId => $qty) {
        $product = Product::find($productId);
        if (!$product)
            continue;
        $name = $product->name_en ?? $product->name ?? 'Product';
        $img = $product->image ?? $product->image_path ?? null;
        if ($img && file_exists(public_path('product_images/' . $img))) {
            $imageUrl = asset('product_images/' . $img);
        } elseif ($img && file_exists(public_path('images/' . $img))) {
            $imageUrl = asset('images/' . $img);
        } else {
            $imageUrl = asset('images/placeholder.png');
        }
        $mrp = (float) ($product->mrp ?? $product->rate ?? $product->price ?? 0);
        $price = (float) ($product->price ?? $mrp);
        $qty = (int) $qty;
        $cartItems[] = compact('product', 'name', 'imageUrl', 'mrp', 'price', 'qty');
        $netTotal += $mrp * $qty;
        $discountTotal += ($mrp - $price) * $qty;
    }

    $subTotal = $netTotal - $discountTotal;

    $zones = DeliveryZone::orderBy('state_name')->get();
    $zonesJs = $zones->map(fn($z) => [
        'state_name' => $z->state_name,
        'packing_charges' => (float) $z->packing_charges,
        'min_order_amount' => (float) $z->min_order_amount,
        'all_cities' => (bool) $z->all_cities,
        'cities' => $z->cities ?? [],
    ])->values()->toArray();
@endphp

{{-- ═══════════════════ CART DRAWER ═══════════════════ --}}
<div class="cdr-wrap" id="cdrWrap" data-subtotal="{{ $subTotal }}">

    {{-- ── SHARED HEADER ── --}}
    <div class="cdr-header">
        <span class="cdr-shop-name"><i class="fas fa-file-invoice me-2"></i> Estimate Bill</span>
        <button class="cdr-close" id="closeCartPanelPartial" title="Close">&times;</button>
    </div>

    {{-- ══════════ PANEL 1 – CART ══════════ --}}
    <div id="cdrPanel1" class="cdr-body">

        @if(count($cartItems) === 0)
            <div class="cdr-empty">
                <i class="fas fa-shopping-cart fa-3x mb-3" style="color:#ccc;"></i>
                <p class="text-muted">Your cart is empty.</p>
            </div>
        @else

            <div class="cdr-items">
                @foreach($cartItems as $item)
                    <div class="cdr-item">
                        <button class="cdr-item-remove qty-remove" data-id="{{ $item['product']->id }}">&times;</button>
                        <div class="cdr-item-thumb">
                            <img src="{{ $item['imageUrl'] }}" alt="{{ $item['name'] }}">
                        </div>
                        <div class="cdr-item-details">
                            <div class="cdr-item-name">{{ $item['name'] }}</div>
                            <div class="cdr-item-price-row">
                                <input type="number" class="cdr-qty-input" value="{{ $item['qty'] }}" min="1"
                                    data-id="{{ $item['product']->id }}">
                                <span class="cdr-x">X</span>
                                <span class="cdr-unit-price">₹ {{ number_format($item['price'], 0) }}</span>
                            </div>
                        </div>
                        <div class="cdr-item-total">₹ {{ number_format($item['price'] * $item['qty'], 2) }}</div>
                    </div>
                @endforeach
            </div>

            <hr class="cdr-divider">

            <div class="cdr-totals">
                <div class="cdr-total-row subtotal">
                    <span>Sub Total</span><span>₹ {{ number_format($subTotal, 2) }}</span>
                </div>
            </div>

            <button type="button" class="cdr-confirm-btn" id="cdrGoToForm">CONFIRM ESTIMATE</button>

        @endif

        @if($zones->where('min_order_amount', '>', 0)->count() > 0)
            <div class="cdr-minorder">
                <div class="cdr-minorder-title">Min.Order Amount</div>
                <div class="cdr-minorder-grid">
                    @foreach($zones->where('min_order_amount', '>', 0) as $zone)
                        <div class="cdr-mo-state">{{ $zone->state_name }}</div>
                        <div class="cdr-mo-amount">Rs.{{ number_format($zone->min_order_amount, 0) }}</div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>{{-- /panel1 --}}

    {{-- ══════════ PANEL 2 – ESTIMATE FORM ══════════ --}}
    <div id="cdrPanel2" class="cdr-body" style="display:none;">
        <form id="cdrEstimateForm" method="POST" action="{{ route('checkout.place') }}">
            @csrf

            {{-- Hidden cart fields --}}
            @foreach($cartItems as $item)
                <input type="hidden" name="cart_ids[]" value="{{ $item['product']->id }}">
                <input type="hidden" name="cart_qtys[]" value="{{ $item['qty'] }}">
            @endforeach

            {{-- STATE --}}
            <div class="cdr-form-row">
                <label class="cdr-form-label">State (*)</label>
                <div class="cdr-form-field">
                    @if($zones->count() > 0)
                        <select name="state" id="cdrStateSelect" class="cdr-select" required>
                            <option value="">-- Select State --</option>
                            @foreach($zones as $z)
                                <option value="{{ $z->state_name }}" data-packing="{{ $z->packing_charges }}"
                                    data-min="{{ $z->min_order_amount }}" data-allcities="{{ $z->all_cities ? '1' : '0' }}"
                                    data-cities="{{ json_encode($z->cities ?? []) }}">
                                    {{ $z->state_name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="state" class="cdr-input" required placeholder="Enter state">
                    @endif
                </div>
            </div>

            {{-- CITY --}}
            <div class="cdr-form-row">
                <label class="cdr-form-label">Select District / City</label>
                <div class="cdr-form-field" id="cdrCityWrap">
                    <select name="city" id="cdrCitySelect" class="cdr-select" required>
                        <option value="">-- Select District / City --</option>
                    </select>
                </div>
            </div>

            {{-- NAME --}}
            <div class="cdr-form-row">
                <label class="cdr-form-label">Name (*)</label>
                <div class="cdr-form-field">
                    <input type="text" name="name" class="cdr-input" required placeholder="Your full name">
                </div>
            </div>

            {{-- MOBILE --}}
            <div class="cdr-form-row">
                <label class="cdr-form-label">Mobile.No (*)</label>
                <div class="cdr-form-field">
                    <input type="tel" name="phone" class="cdr-input" required placeholder="10-digit number"
                        maxlength="10">
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="cdr-form-row">
                <label class="cdr-form-label">Email</label>
                <div class="cdr-form-field">
                    <input type="email" name="email" class="cdr-input" placeholder="your@email.com">
                </div>
            </div>

            {{-- ADDRESS --}}
            <div class="cdr-form-row cdr-form-row--top">
                <label class="cdr-form-label">Address (*)</label>
                <div class="cdr-form-field">
                    <textarea name="address" class="cdr-textarea" rows="3" required
                        placeholder="House No, Street, Landmark..."></textarea>
                </div>
            </div>

            <hr class="cdr-divider">

            {{-- ORDER SUMMARY --}}
            <div class="cdr-order-summary">
                <div class="cdr-os-row">
                    <span>Sub Total</span>
                    <span>₹&nbsp;{{ number_format($subTotal, 2) }}</span>
                </div>
                <div class="cdr-os-row cdr-os-min" id="cdrMinOrderRow" style="display:none;">
                    <span>Min.Order Amount</span>
                    <span id="cdrMinOrderVal">₹&nbsp;0</span>
                </div>
                <div class="cdr-os-row" id="cdrPackingRow" style="display:none;">
                    <span id="cdrPackingLabel">Packing Charges</span>
                    <span id="cdrPackingVal">₹&nbsp;0.00</span>
                </div>

                <div class="cdr-os-row cdr-os-overall">
                    <span>Overall Amount</span>
                    <span id="cdrOverallAmt">₹&nbsp;{{ number_format($subTotal, 2) }}</span>
                </div>
            </div>

            <input type="hidden" name="packing_charges" id="cdrPackingHidden" value="0">
            <input type="hidden" name="subtotal" value="{{ $subTotal }}">

            {{-- BUTTONS --}}
            <div class="cdr-btn-row">
                <button type="submit" class="cdr-btn-submit">Submit</button>
                <button type="button" class="cdr-btn-back" id="cdrBackBtn">Back</button>
            </div>

        </form>
    </div>{{-- /panel2 --}}

</div>{{-- /cdr-wrap --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .cdr-wrap {
        display: flex;
        flex-direction: column;
        height: 100%;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        background: #f8fafc;
        color: #334155;
    }

    /* Header */
    .cdr-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #a50000 0%, #8B1A1A 100%);
        color: #fff;
        padding: 18px 24px;
        font-size: 18px;
        font-weight: 800;
        letter-spacing: 0.5px;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(139, 26, 26, 0.2);
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
        position: relative;
        z-index: 10;
    }

    .cdr-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .cdr-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    /* Body */
    .cdr-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px 24px 30px;
    }

    /* Scrollbar */
    .cdr-body::-webkit-scrollbar {
        width: 6px;
    }

    .cdr-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Cart items */
    .cdr-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cdr-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    }

    .cdr-item-remove {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #fee2e2;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #ef4444;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(239, 68, 68, 0.2);
        transition: all 0.2s ease;
        opacity: 0;
    }

    .cdr-item:hover .cdr-item-remove {
        opacity: 1;
    }

    .cdr-item-remove:hover {
        background: #ef4444;
        color: #fff;
        transform: scale(1.1);
    }

    .cdr-item-thumb img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .cdr-item-details {
        flex: 1;
        min-width: 0;
    }

    .cdr-item-name {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cdr-item-price-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cdr-qty-input {
        width: 60px;
        height: 32px;
        text-align: center;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .cdr-qty-input:focus {
        border-color: #8B1A1A;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1);
    }

    .cdr-qty-input::-webkit-inner-spin-button,
    .cdr-qty-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .cdr-qty-input {
        -moz-appearance: textfield;
    }

    .cdr-x {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 800;
    }

    .cdr-unit-price {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
    }

    .cdr-item-total {
        font-size: 15px;
        font-weight: 800;
        color: #8B1A1A;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .cdr-empty {
        text-align: center;
        padding: 80px 0 40px;
    }

    .cdr-empty i {
        color: #cbd5e1;
    }

    .cdr-empty p {
        color: #64748b;
        font-size: 16px;
        font-weight: 500;
        margin-top: 15px;
    }

    .cdr-divider {
        border: none;
        border-top: 1px dashed #cbd5e1;
        margin: 20px 0;
    }

    /* Cart totals */
    .cdr-totals {
        background: #fff;
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .cdr-total-row {
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        color: #475569;
        padding: 4px 0;
    }

    .cdr-total-row.subtotal {
        font-weight: 800;
        font-size: 16px;
        color: #0f172a;
        border-top: 1px solid #e2e8f0;
        margin-top: 8px;
        padding-top: 12px;
    }

    /* Confirm button */
    .cdr-confirm-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 0.5px;
        padding: 16px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        margin-bottom: 24px;
        transition: all 0.2s ease;
    }

    .cdr-confirm-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .cdr-confirm-btn::after {
        content: '→';
        font-family: Arial;
        font-size: 18px;
    }

    /* Min order table */
    .cdr-minorder {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #fecaca;
        padding: 15px;
    }

    .cdr-minorder-title {
        text-align: center;
        color: #dc2626;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .cdr-minorder-grid {
        display: grid;
        grid-template-columns: 1fr auto;
        row-gap: 8px;
        column-gap: 15px;
    }

    .cdr-mo-state {
        font-size: 13px;
        color: #475569;
        font-weight: 500;
    }

    .cdr-mo-amount {
        font-size: 13px;
        color: #dc2626;
        font-weight: 700;
        text-align: right;
    }

    /* ── Estimate Form ── */
    #cdrPanel2 {
        background: #fff;
    }

    .cdr-form-row {
        margin-bottom: 18px;
    }

    .cdr-form-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .cdr-input,
    .cdr-select,
    .cdr-textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 14.5px;
        font-weight: 500;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .cdr-input:focus,
    .cdr-select:focus,
    .cdr-textarea:focus {
        border-color: #8B1A1A;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1);
    }

    .cdr-textarea {
        resize: vertical;
        min-height: 80px;
    }

    /* Order summary */
    .cdr-order-summary {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px 20px;
        margin: 10px 0 24px;
    }

    .cdr-os-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 6px 0;
        color: #475569;
        font-weight: 500;
    }

    .cdr-os-min {
        color: #dc2626;
        font-weight: 700;
    }

    .cdr-os-overall {
        font-weight: 800;
        font-size: 17px;
        color: #8B1A1A;
        border-top: 1px solid #cbd5e1;
        margin-top: 8px;
        padding-top: 12px;
    }

    /* Buttons */
    .cdr-btn-row {
        display: flex;
        gap: 12px;
    }

    .cdr-btn-submit {
        flex: 2;
        background: linear-gradient(135deg, #a50000 0%, #8B1A1A 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 14px;
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(139, 26, 26, 0.25);
        transition: all 0.2s ease;
    }

    .cdr-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 26, 26, 0.35);
    }

    .cdr-btn-back {
        flex: 1;
        background: #fff;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 14px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .cdr-btn-back:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    /* ── City Tag Pill Grid ── */
    .cdr-city-tagbox {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
        background: #f8fafc;
        max-height: 200px;
        overflow-y: auto;
        width: 100%;
    }

    .cdr-city-tagbox::-webkit-scrollbar {
        width: 5px;
    }

    .cdr-city-tagbox::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .cdr-city-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .cdr-city-tag {
        display: inline-block;
        padding: 6px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        background: #fff;
        font-size: 12.5px;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }

    .cdr-city-tag:hover {
        border-color: #8B1A1A;
        color: #8B1A1A;
        background: #fff0f0;
        transform: translateY(-1px);
    }

    .cdr-city-tag.active {
        background: linear-gradient(135deg, #a50000 0%, #8B1A1A 100%);
        color: #fff;
        border-color: transparent;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(139, 26, 26, 0.3);
    }
</style>