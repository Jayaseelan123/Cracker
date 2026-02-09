@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Edit Product</h2>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back to list</a>
</div>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Name (EN)</label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $product->name_en ?? $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Name (TA)</label>
                <input type="text" name="name_ta" class="form-control" value="{{ old('name_ta', $product->name_ta) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Rate</label>
                <input type="number" name="rate" class="form-control" value="{{ old('rate', $product->rate ?? $product->price ?? $product->mrp) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Discount Rate</label>
                <input type="number" name="discount_rate" class="form-control" value="{{ old('discount_rate', $product->discount_rate ?? 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Final Price</label>
                <input type="number" name="final_price" class="form-control" value="{{ old('final_price', $product->final_price ?? 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                @if($product->image)
                    <div class="mb-2"><img src="{{ asset('product_images/'.$product->image) }}" width="80"></div>
                @endif
                <input type="file" name="image" class="form-control">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-primary" type="submit">Update Product</button>
    </div>
</form>

@endsection
