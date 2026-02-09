@extends('layouts.admin')

@section('content')
<h2>Products</h2>

<div class="d-flex justify-content-between mb-3">
    <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control" placeholder="Search products..." />
        <button class="btn btn-primary ms-2">Search</button>
    </form>
    <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>SKU</th>
            <th>Name (EN)</th>
            <th>Name (TA)</th>
            <th>Rate</th>
            <th>Discount</th>
            <th>Final Price</th>
            <th>Min</th>
            <th>Max</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->sku ?? '—' }}</td>
            <td>{{ $product->name_en ?? $product->name ?? '—' }}</td>
            <td>{{ $product->name_ta ?? '—' }}</td>
            @php
                $displayRate = $product->rate ?? $product->price ?? $product->mrp ?? null;
                $displayDiscount = $product->discount_rate ?? 0;
                $displayFinal = $product->final_price ?? $product->price ?? $displayRate ?? 0;
            @endphp
            <td>₹{{ $displayRate !== null ? number_format($displayRate, 2) : '—' }}</td>
            <td>₹{{ number_format($displayDiscount, 2) }}</td>
            <td>₹{{ $displayFinal ? number_format($displayFinal, 2) : '—' }}</td>
            <td>{{ $product->min_order_value ?? '—' }}</td>
            <td>{{ $product->max_order_value ?? '—' }}</td>
            <td>{{ $product->stock ?? '—' }}</td>
            <td>{{ optional($product->category)->name ?? '—' }}</td>
            <td><span class="badge bg-{{ ($product->status ?? 'Active') === 'Active' ? 'success' : 'secondary' }}">{{ $product->status ?? 'Active' }}</span></td>
            <td>
                @php $img = $product->image_path ?? $product->image ?? null; @endphp
                @if($img)
                    <img src="{{ asset('product_images/'.$img) }}" width="50" alt="{{ $product->name_en ?? $product->name ?? '' }}">
                @else
                    —
                @endif
            </td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}

@endsection
