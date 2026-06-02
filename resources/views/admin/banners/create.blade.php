@extends('layouts.admin')

@section('header', 'Add New Banner')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-image me-2 text-primary"></i>Banner Details</h5>
                        <a href="{{ route('banners.index') }}" class="btn btn-sm btn-light border text-muted">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('banners.store') }}" method="POST">
                        @csrf

                        <p class="text-muted small mb-4">Note: <span class="text-danger fw-bold">*</span> Required fields</p>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Banner Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg border-light-subtle bg-light bg-opacity-50" placeholder="E.g., Mega Diwali Sale" value="{{ old('title') }}" required>
                            @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Banner Subtitle <span class="text-danger">*</span></label>
                            <input type="text" name="subtitle" class="form-control form-control-lg border-light-subtle bg-light bg-opacity-50" placeholder="E.g., Up to 50% off on all crackers" value="{{ old('subtitle') }}" required>
                            @error('subtitle')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Select Banner Image <span class="text-danger">*</span></label>
                            <select name="image" id="imageSelect" class="form-select form-select-lg border-light-subtle bg-light bg-opacity-50" required>
                                <option value="">-- Choose an image --</option>
                                @foreach($images as $img)
                                    <option value="{{ $img }}" {{ old('image') == $img ? 'selected' : '' }}>{{ basename($img) }}</option>
                                @endforeach
                            </select>
                            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                            
                            <!-- Image Preview Area -->
                            <div class="mt-3 d-none" id="imagePreviewContainer">
                                <label class="form-label fw-semibold small text-muted text-uppercase">Image Preview</label>
                                <div class="rounded-3 overflow-hidden border border-2 shadow-sm" style="max-height: 250px; background: #f8fafc;">
                                    <img src="" id="imagePreview" class="w-100 h-100 object-fit-contain" style="max-height: 250px; object-fit: contain;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Banner Status</label>
                            <select name="is_active" class="form-select form-select-lg border-light-subtle bg-light bg-opacity-50">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active - Visible in website</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive - Not visible in website</option>
                            </select>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm hover-up py-3">
                            <i class="fas fa-save me-2"></i> Save Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageSelect = document.getElementById('imageSelect');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImg = document.getElementById('imagePreview');

        function updatePreview() {
            if (imageSelect.value) {
                previewImg.src = '{{ asset('') }}' + imageSelect.value;
                previewContainer.classList.remove('d-none');
            } else {
                previewContainer.classList.add('d-none');
            }
        }

        imageSelect.addEventListener('change', updatePreview);
        
        // Initial check
        if(imageSelect.value) {
            updatePreview();
        }
    });
</script>

<style>
    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4) !important;
    }
    .hover-up {
        transition: all 0.2s ease;
    }
</style>
@endsection
