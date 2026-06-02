@extends('layouts.admin')

@section('title', 'Company Settings')
@section('header', 'Company Settings')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,#6f42c1,#a855f7);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-building text-white fs-5"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Company Settings</h2>
                    <p class="text-muted mb-0 small">Update your company info, logo & bank details — this reflects on the website footer.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.company.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- ===================== LEFT COLUMN: Company Info ===================== --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-bottom py-3 px-4">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Company Information
                        </h6>
                    </div>
                    <div class="card-body px-4 py-4">

                        {{-- Company Name --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark" for="company_name">
                                <i class="fas fa-building me-1 text-muted"></i>Company Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="company_name" name="company_name"
                                class="form-control rounded-3 @error('company_name') is-invalid @enderror"
                                value="{{ old('company_name', $company->company_name) }}"
                                placeholder="e.g. CrackerTime Pvt. Ltd." required>
                            @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark" for="address">
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i>Address <span class="text-danger">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3"
                                class="form-control rounded-3 @error('address') is-invalid @enderror"
                                placeholder="Full company address..." required>{{ old('address', $company->address) }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Contact Number --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark" for="contact_number">
                                <i class="fas fa-phone me-1 text-muted"></i>Contact Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="contact_number" name="contact_number"
                                class="form-control rounded-3 @error('contact_number') is-invalid @enderror"
                                value="{{ old('contact_number', $company->contact_number) }}"
                                placeholder="+91 9XXXXXXXXX" required>
                            @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- WhatsApp Number --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark" for="whatsapp_number">
                                <i class="fab fa-whatsapp me-1 text-success"></i>WhatsApp Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number"
                                class="form-control rounded-3 @error('whatsapp_number') is-invalid @enderror"
                                value="{{ old('whatsapp_number', $company->whatsapp_number) }}"
                                placeholder="+91 9XXXXXXXXX" required>
                            @error('whatsapp_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- ===================== RIGHT COLUMN: Logo ===================== --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-bottom py-3 px-4">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-image me-2 text-primary"></i>Company Logo
                        </h6>
                    </div>
                    <div class="card-body px-4 py-4 text-center">

                        {{-- Current Logo Preview --}}
                        <div id="logoPreviewWrap" class="mb-3">
                            @if($company->logo)
                                <img id="logoPreview" src="{{ asset($company->logo) }}" alt="Company Logo"
                                    class="rounded-3 shadow-sm border"
                                    style="max-width:180px;max-height:120px;object-fit:contain;">
                            @else
                                <div id="logoPlaceholder" class="d-flex flex-column align-items-center justify-content-center rounded-3 border border-dashed"
                                    style="width:100%;height:120px;background:#f8fafc;">
                                    <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                    <span class="text-muted small">No logo uploaded</span>
                                </div>
                                <img id="logoPreview" src="" alt="Logo Preview"
                                    class="rounded-3 shadow-sm border d-none"
                                    style="max-width:180px;max-height:120px;object-fit:contain;">
                            @endif
                        </div>

                        <label class="form-label fw-semibold text-dark d-block" for="logo">
                            Upload Logo <span class="text-muted fw-normal">(JPG/PNG/WebP/SVG · Max 2MB)</span>
                        </label>
                        <input type="file" id="logo" name="logo" accept="image/*"
                            class="form-control rounded-3 @error('logo') is-invalid @enderror"
                            onchange="previewLogo(this)">
                        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <p class="text-muted small mt-2 mb-0">
                            <i class="fas fa-info-circle me-1"></i>Leave blank to keep the current logo.
                        </p>

                    </div>
                </div>
            </div>

            {{-- ===================== BANK DETAILS ===================== --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-bottom py-3 px-4">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-university me-2 text-primary"></i>Bank Details
                        </h6>
                    </div>
                    <div class="card-body px-4 py-4">
                        <div class="row g-4">

                            {{-- A/C Number --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark" for="bank_ac_no">
                                    <i class="fas fa-hashtag me-1 text-muted"></i>Account Number
                                </label>
                                <input type="text" id="bank_ac_no" name="bank_ac_no"
                                    class="form-control rounded-3 @error('bank_ac_no') is-invalid @enderror"
                                    value="{{ old('bank_ac_no', $company->bank_ac_no) }}"
                                    placeholder="e.g. 123456789012">
                                @error('bank_ac_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- A/C Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark" for="bank_ac_name">
                                    <i class="fas fa-user me-1 text-muted"></i>Account Holder Name
                                </label>
                                <input type="text" id="bank_ac_name" name="bank_ac_name"
                                    class="form-control rounded-3 @error('bank_ac_name') is-invalid @enderror"
                                    value="{{ old('bank_ac_name', $company->bank_ac_name) }}"
                                    placeholder="e.g. CrackerTime Pvt. Ltd.">
                                @error('bank_ac_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- A/C Type --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark" for="bank_ac_type">
                                    <i class="fas fa-layer-group me-1 text-muted"></i>Account Type
                                </label>
                                <select id="bank_ac_type" name="bank_ac_type"
                                    class="form-select rounded-3 @error('bank_ac_type') is-invalid @enderror">
                                    <option value="">-- Select Type --</option>
                                    <option value="Savings" {{ old('bank_ac_type', $company->bank_ac_type) == 'Savings' ? 'selected' : '' }}>Savings</option>
                                    <option value="Current" {{ old('bank_ac_type', $company->bank_ac_type) == 'Current' ? 'selected' : '' }}>Current</option>
                                    <option value="OD" {{ old('bank_ac_type', $company->bank_ac_type) == 'OD' ? 'selected' : '' }}>Overdraft (OD)</option>
                                    <option value="NRI" {{ old('bank_ac_type', $company->bank_ac_type) == 'NRI' ? 'selected' : '' }}>NRI</option>
                                </select>
                                @error('bank_ac_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Bank Name --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark" for="bank_name">
                                    <i class="fas fa-university me-1 text-muted"></i>Bank Name
                                </label>
                                <input type="text" id="bank_name" name="bank_name"
                                    class="form-control rounded-3 @error('bank_name') is-invalid @enderror"
                                    value="{{ old('bank_name', $company->bank_name) }}"
                                    placeholder="e.g. State Bank of India">
                                @error('bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- IFSC Code --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark" for="bank_ifsc">
                                    <i class="fas fa-code me-1 text-muted"></i>IFSC Code
                                </label>
                                <input type="text" id="bank_ifsc" name="bank_ifsc"
                                    class="form-control rounded-3 @error('bank_ifsc') is-invalid @enderror"
                                    value="{{ old('bank_ifsc', $company->bank_ifsc) }}"
                                    placeholder="e.g. SBIN0001234"
                                    style="text-transform:uppercase;"
                                    oninput="this.value=this.value.toUpperCase()">
                                @error('bank_ifsc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3 shadow-sm">
                    <i class="fas fa-save me-2"></i>Save Company Details
                </button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    const placeholder = document.getElementById('logoPlaceholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
