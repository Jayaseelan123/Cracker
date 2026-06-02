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
    <p class="text-muted small mb-3">Note: <span class="text-danger fw-bold">*</span> Required fields</p>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Name (EN) <span class="text-danger">*</span></label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Name (TA)</label>
                <input type="text" name="name_ta" class="form-control" value="{{ old('name_ta') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
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
                <label class="form-label">Rate <span class="text-danger">*</span></label>
                <input type="number" name="rate" class="form-control" value="{{ old('rate') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Discount Rate</label>
                <input type="number" name="discount_rate" class="form-control" value="{{ old('discount_rate', 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Final Price <span class="text-danger">*</span></label>
                <input type="number" name="final_price" class="form-control" value="{{ old('final_price', 0) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active - Visible in website</option>
                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive - Not visible in website</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-upload me-1 text-success"></i>Upload Video File <small class="text-muted fw-normal">(MP4 · Max 50MB) — Plays directly in popup</small>
                </label>
                <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/ogg">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-brands fa-youtube me-1 text-danger"></i>OR YouTube URL <small class="text-muted fw-normal">(only if video file not uploaded)</small>
                </label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                <div class="form-text text-warning"><i class="fas fa-exclamation-triangle me-1"></i>YouTube Shorts/videos must have embedding enabled. If it shows "Video unavailable", upload an MP4 file instead.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Video Status</label>
                <select name="video_status" class="form-select">
                    <option value="Active" {{ old('video_status', 'Active') == 'Active' ? 'selected' : '' }}>Active - Visible in website</option>
                    <option value="Inactive" {{ old('video_status') == 'Inactive' ? 'selected' : '' }}>Inactive - Hidden</option>
                </select>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-success" type="submit">Create Product</button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rateInput = document.querySelector('input[name="rate"]');
        const discountInput = document.querySelector('input[name="discount_rate"]');
        const finalPriceInput = document.querySelector('input[name="final_price"]');

        function calculateFinalPrice() {
            const rate = parseFloat(rateInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const finalPrice = rate - discount;
            
            finalPriceInput.value = finalPrice.toFixed(2);
            
            if (finalPrice < 0) {
                finalPriceInput.classList.add('is-invalid');
                discountInput.classList.add('is-invalid');
            } else {
                finalPriceInput.classList.remove('is-invalid');
                discountInput.classList.remove('is-invalid');
            }
        }

        rateInput.addEventListener('input', calculateFinalPrice);
        discountInput.addEventListener('input', calculateFinalPrice);
        
        // Prevent form submission if final price is negative
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const rate = parseFloat(rateInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            if (discount > rate) {
                e.preventDefault();
                alert('Discount cannot be greater than the Rate (MRP).');
            }
        });
        
        // Run once on load to sync values
        calculateFinalPrice();
    });
</script>
@endpush
@endsection
