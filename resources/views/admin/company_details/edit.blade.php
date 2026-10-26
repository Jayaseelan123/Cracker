@extends('layouts.admin')

@section('title', 'Company Settings')
@section('header', 'Company Settings')

@section('content')
    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center gap-3">
                    <div
                        style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,#6f42c1,#a855f7);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-building text-white fs-5"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">Company Settings</h2>
                        <p class="text-muted mb-0 small">Update your company info, logo & bank details — this reflects on
                            the website footer.</p>
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
                                    <i class="fas fa-building me-1 text-muted"></i>Company Name <span
                                        class="text-danger">*</span>
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
                                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>Address <span
                                        class="text-danger">*</span>
                                </label>
                                <textarea id="address" name="address" rows="3"
                                    class="form-control rounded-3 @error('address') is-invalid @enderror"
                                    placeholder="Full company address..."
                                    required>{{ old('address', $company->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Contact Number --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark" for="contact_number">
                                    <i class="fas fa-phone me-1 text-muted"></i>Contact Number <span
                                        class="text-danger">*</span>
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
                                    <i class="fab fa-whatsapp me-1 text-success"></i>WhatsApp Number <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" id="whatsapp_number" name="whatsapp_number"
                                    class="form-control rounded-3 @error('whatsapp_number') is-invalid @enderror"
                                    value="{{ old('whatsapp_number', $company->whatsapp_number) }}"
                                    placeholder="+91 9XXXXXXXXX" required>
                                @error('whatsapp_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Contact Info Preview --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Contact Info Preview</label>
                                <div id="contactPreview" class="border rounded-3 p-3"
                                    style="background:linear-gradient(180deg,#ffffff,#fbfdff);">
                                    <div class="d-flex align-items-start gap-3">
                                        <div
                                            style="width:56px;height:56px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-store text-primary fa-lg"></i>
                                        </div>
                                        <div class="flex-fill">
                                            <div
                                                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-2">
                                                <div>
                                                    <div id="previewCompanyName" class="fw-bold">
                                                        {{ $company->company_name ?? 'Company Name' }}</div>
                                                    <div id="previewAddress" class="text-muted small">
                                                        {{ $company->address ?? 'D No 3/1362,CA,Bharathi nagar Sattur road, Kasthuripyro – 626 189' }}
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <a id="previewWhatsAppLink"
                                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', old('whatsapp_number', $company->whatsapp_number ?? '9787515558')) }}"
                                                        target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fab fa-whatsapp me-1"></i>Chat
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="mt-1">
                                                <span class="me-3"><i class="fas fa-phone me-1 text-muted"></i><span
                                                        id="previewPhone">{{ $company->contact_number ?? '807288549' }}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <div id="logoPlaceholder"
                                        class="d-flex flex-column align-items-center justify-content-center rounded-3 border border-dashed"
                                        style="width:100%;height:120px;background:#f8fafc;">
                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                        <span class="text-muted small">No logo uploaded</span>
                                    </div>
                                    <img id="logoPreview" src="" alt="Logo Preview" class="rounded-3 shadow-sm border d-none"
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
                            <p class="text-muted small mt-2 mb-0 text-start">
                                <i class="fas fa-info-circle me-1"></i>Leave blank to keep the current logo.
                            </p>

                            <hr class="my-4">

                            {{-- Favicon Upload --}}
                            <div class="text-start">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="fas fa-star me-2 text-warning"></i>Favicon
                                </h6>
                                <label class="form-label fw-semibold text-dark d-block" for="favicon">
                                    Upload Favicon <span class="text-muted fw-normal">(ICO/PNG/JPG/WebP/SVG · Max
                                        512KB)</span>
                                </label>
                                <input type="file" id="favicon" name="favicon" accept="image/*,.ico"
                                    class="form-control rounded-3 @error('favicon') is-invalid @enderror"
                                    onchange="previewFavicon(this)">
                                @error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                <div id="faviconPreviewWrap" class="mt-3">
                                    @if($company->favicon)
                                        <img id="faviconPreview" src="{{ asset($company->favicon) }}" alt="Favicon"
                                            class="rounded-2 shadow-sm border"
                                            style="max-width:64px;max-height:64px;object-fit:contain;">
                                    @else
                                        <img id="faviconPreview" src="" alt="Favicon Preview"
                                            class="rounded-2 shadow-sm border d-none"
                                            style="max-width:64px;max-height:64px;object-fit:contain;">
                                    @endif
                                </div>
                            </div>

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
                                        value="{{ old('bank_ifsc', $company->bank_ifsc) }}" placeholder="e.g. SBIN0001234"
                                        style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
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
    <style>
        /* =========================================
       COMPANY SETTINGS MOBILE RESPONSIVE FIX
    ========================================= */

        html,
        body {
            overflow-x: hidden;
            width: 100%;
        }

        .container-fluid {
            max-width: 100%;
        }

        /* Header */
        @media (max-width: 768px) {

            .container-fluid.py-4 {
                padding: 15px !important;
            }

            h2.fw-bold {
                font-size: 22px;
            }

            .text-muted.small {
                font-size: 13px !important;
            }

            .d-flex.align-items-center.gap-3 {
                flex-wrap: wrap;
            }
        }

        /* Cards */
        .card {
            overflow: hidden;
        }

        .card-header {
            padding: 15px 20px !important;
        }

        .card-body {
            padding: 20px !important;
        }

        /* Inputs */
        .form-control,
        .form-select {
            min-height: 46px;
            font-size: 14px;
        }

        textarea.form-control {
            min-height: 100px;
        }

        /* Contact Preview */
        #contactPreview {
            overflow: hidden;
        }

        #contactPreview .d-flex {
            flex-wrap: wrap;
        }

        #previewCompanyName,
        #previewAddress,
        #previewPhone {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        #previewWhatsAppLink {
            white-space: nowrap;
        }

        /* Logo Preview */
        #logoPreview,
        #faviconPreview {
            max-width: 100%;
            height: auto;
        }

        #logoPreviewWrap img {
            width: auto;
            max-width: 180px;
        }

        /* Bank Details */
        @media (max-width: 768px) {

            .row.g-4>.col-md-6,
            .row.g-4>.col-md-4,
            .row.g-4>.col-lg-7,
            .row.g-4>.col-lg-5 {
                width: 100%;
            }
        }

        /* Mobile Layout */
        @media (max-width: 768px) {

            .card-body.px-4.py-4,
            .card-body {
                padding: 15px !important;
            }

            .card-header.py-3.px-4 {
                padding: 15px !important;
            }

            .form-label {
                font-size: 14px;
            }

            .btn-lg {
                width: 100%;
                padding: 12px !important;
                font-size: 15px;
            }

            .text-end {
                text-align: center !important;
            }
        }

        /* Contact Preview Mobile */
        @media (max-width: 576px) {

            #contactPreview .d-flex.align-items-start.gap-3 {
                flex-direction: column;
                align-items: center !important;
                text-align: center;
            }

            #contactPreview .text-end {
                text-align: center !important;
                width: 100%;
            }

            #previewWhatsAppLink {
                width: 100%;
            }
        }

        /* Logo & Favicon Mobile */
        @media (max-width: 576px) {

            #logoPreview {
                max-width: 140px !important;
                max-height: 100px !important;
            }

            #faviconPreview {
                max-width: 50px !important;
                max-height: 50px !important;
            }

            #logoPlaceholder {
                height: 100px !important;
            }
        }

        /* Save Button */
        @media (max-width: 768px) {

            .btn.btn-primary.btn-lg {
                width: 100%;
                display: block;
            }
        }

        /* Alert */
        @media (max-width: 576px) {

            .alert {
                font-size: 14px;
                padding: 12px;
            }

            .alert .btn-close {
                padding: 12px;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 375px) {

            h2.fw-bold {
                font-size: 20px;
            }

            .card-body {
                padding: 12px !important;
            }

            .form-control,
            .form-select {
                font-size: 13px;
            }

            .btn-lg {
                font-size: 14px;
            }
        }

        /* Prevent Text Overflow */
        .card,
        .card-body,
        .form-control,
        .form-select,
        .btn,
        .alert {
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
    @push('scripts')
        <script>
            function previewLogo(input) {
                const preview = document.getElementById('logoPreview');
                const placeholder = document.getElementById('logoPlaceholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        if (placeholder) placeholder.classList.add('d-none');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function previewFavicon(input) {
                const preview = document.getElementById('faviconPreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function updateContactPreview() {
                const companyNameEl = document.getElementById('previewCompanyName');
                const addressEl = document.getElementById('previewAddress');
                const phoneEl = document.getElementById('previewPhone');
                const waLinkEl = document.getElementById('previewWhatsAppLink');

                const nameInput = document.getElementById('company_name');
                const addressInput = document.getElementById('address');
                const phoneInput = document.getElementById('contact_number');
                const waInput = document.getElementById('whatsapp_number');

                if (companyNameEl && nameInput) companyNameEl.textContent = nameInput.value || 'Company Name';
                if (addressEl && addressInput) addressEl.textContent = addressInput.value || 'D No 3/1362,CA,Bharathi nagar Sattur road, Kasthuripyro – 626 189';
                if (phoneEl && phoneInput) phoneEl.textContent = phoneInput.value || '807288549';
                if (waLinkEl && waInput) {
                    const digits = (waInput.value || '').replace(/[^0-9]/g, '');
                    if (digits.length) {
                        waLinkEl.href = 'https://wa.me/' + digits;
                        waLinkEl.classList.remove('disabled');
                    } else {
                        waLinkEl.href = '#';
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                // attach listeners
                ['company_name', 'address', 'contact_number', 'whatsapp_number'].forEach(function (id) {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('input', updateContactPreview);
                });
                // initialize preview
                updateContactPreview();
            });
        </script>
    @endpush

@endsection