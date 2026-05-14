@extends('layouts.app')

@section('title', 'Shop')

@section('hero_title', 'Welcome to CrackerTime')
@section('hero_subtitle', 'Shop the best festive crackers')

@section('content')
    @foreach($categories as $category)
        <div class="category-header">{{ $category->name }}</div>

        <div class="table-responsive">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Image</th>
                        <th style="text-align:left;">Product</th>
                        <th style="text-align:center;">MRP</th>
                        <th style="text-align:center;">Price</th>
                        <th style="text-align:center;">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->products as $product)
                        <tr class="product-row">
                            <td style="text-align:left;"><img
                                    src="{{ asset('product_images/' . ($product->image_path ?: $product->image ?: 'demo.jpg')) }}"
                                    alt="{{ $product->name_en ?? $product->name }}"></td>
                            <td style="text-align:left;">
                                <div>{{ $product->name_en ?? $product->name ?? '—' }}</div>
                                @if(!empty($product->name_ta))
                                    <div class="text-muted small">{{ $product->name_ta }}</div>
                                @endif
                            </td>
                            <td style="text-align:center; font-weight: bold; font-size: 1.1em; color: #333;">{{ number_format($product->mrp, 2) }}</td>
                            <td style="text-align:center; font-weight: bold; font-size: 1.1em; color: #333;">{{ number_format($product->price, 2) }}</td>
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
@endsection