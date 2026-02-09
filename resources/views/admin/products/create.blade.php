@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Add Product</h2>
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

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Name (EN)</label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Name (TA)</label>
                <input type="text" name="name_ta" class="form-control" value="{{ old('name_ta') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Rate</label>
                <input type="number" name="rate" class="form-control" value="{{ old('rate') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Discount Rate</label>
                <input type="number" name="discount_rate" class="form-control" value="{{ old('discount_rate', 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Final Price</label>
                <input type="number" name="final_price" class="form-control" value="{{ old('final_price', 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-success" type="submit">Create Product</button>
    </div>
</form>

@endsection
