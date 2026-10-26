@extends('layouts.admin')

@section('header', 'Manage Banners')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Hero Banners</h2>
                        <p class="text-muted mb-0">Manage the hero banners displayed on the homepage</p>
                    </div>
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                        <form method="GET" action="{{ route('banners.index') }}" id="bannerSearchForm"
                            class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2 flex-grow-1">
                            <input type="text" name="search" class="form-control" placeholder="Search banners..."
                                value="{{ request('search') }}" style="min-width: 200px;" />
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-3 flex-fill">Search</button>
                                <a href="{{ route('banners.index') }}" id="resetBannerSearch"
                                    class="btn btn-outline-info px-3 flex-fill d-flex align-items-center justify-content-center"
                                    title="Reset Search">
                                    <i class="fas fa-sync-alt"></i><span class="d-none d-sm-inline ms-1">Reset</span>
                                </a>
                            </div>
                        </form>
                        <a href="{{ route('banners.create') }}"
                            class="btn btn-primary shadow-sm rounded-3 px-4 text-nowrap">
                            <i class="fas fa-plus me-2"></i>Add New Banner
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="bannerListContainer">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Desktop Table -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">S.No</th>
                                    <th>Preview</th>
                                    <th>Title & Subtitle</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                    <tr>
                                        <td class="ps-4">
                                            {{ ($banners->currentPage() - 1) * $banners->perPage() + $loop->iteration }}</td>
                                        <td class="py-3">
                                            <div class="rounded overflow-hidden shadow-sm"
                                                style="width: 120px; height: 60px; background: #f8fafc;">
                                                <img src="{{ asset($banner->image) }}" alt="Banner"
                                                    class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $banner->title ?: 'No Title' }}</div>
                                            <div class="text-muted small">{{ $banner->subtitle ?: 'No Subtitle' }}</div>
                                        </td>
                                        <td>
                                            <form action="{{ route('banners.toggleStatus', $banner->id) }}" method="POST"
                                                class="status-form"
                                                onsubmit="event.preventDefault(); updateBannerStatus(this);">
                                                @csrf
                                                <select name="is_active" onchange="this.form.dispatchEvent(new Event('submit'))"
                                                    class="status-select {{ $banner->is_active ? 'status-active' : 'status-inactive' }}">
                                                    <option value="1" {{ $banner->is_active ? 'selected' : '' }}>● Active
                                                    </option>
                                                    <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>● Inactive
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('banners.edit', $banner->id) }}"
                                                    class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3"
                                                    style="width: 38px; height: 38px;" title="Edit Banner">
                                                    <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                                                </a>
                                                <form action="{{ route('banners.destroy', $banner->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn"
                                                        style="width: 38px; height: 38px;" title="Delete Banner">
                                                        <i class="fas fa-trash-alt" style="font-size: 1.1rem;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-images fa-3x mb-3 opacity-25"></i>
                                                <p class="mb-0">No banners found.</p>
                                                <a href="{{ route('banners.create') }}"
                                                    class="btn btn-outline-primary btn-sm mt-3">Create your first banner</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Cards -->
                <div class="d-block d-md-none p-3 bg-light">
                    @forelse($banners as $banner)
                        <div class="card shadow-sm border-0 rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                    <span class="text-muted fw-bold" style="font-size:0.85rem;">S.No:
                                        {{ ($banners->currentPage() - 1) * $banners->perPage() + $loop->iteration }}</span>
                                </div>

                                <div class="mb-3 text-center">
                                    <div class="rounded overflow-hidden shadow-sm d-inline-block"
                                        style="width: 100%; height: 120px; background: #f8fafc;">
                                        <img src="{{ asset($banner->image) }}" alt="Banner" class="w-100 h-100 object-fit-cover"
                                            style="object-fit: cover;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="fw-bold text-dark fs-6">{{ $banner->title ?: 'No Title' }}</div>
                                    <div class="text-muted small">{{ $banner->subtitle ?: 'No Subtitle' }}</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-muted"
                                        style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Status</div>
                                    <form action="{{ route('banners.toggleStatus', $banner->id) }}" method="POST"
                                        class="status-form m-0" onsubmit="event.preventDefault(); updateBannerStatus(this);">
                                        @csrf
                                        <select name="is_active" onchange="this.form.dispatchEvent(new Event('submit'))"
                                            class="status-select {{ $banner->is_active ? 'status-active' : 'status-inactive' }}"
                                            style="width:100px;">
                                            <option value="1" {{ $banner->is_active ? 'selected' : '' }}>● Active</option>
                                            <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>● Inactive</option>
                                        </select>
                                    </form>
                                </div>

                                <div class="d-flex gap-2 pt-3 border-top mt-2">
                                    <a href="{{ route('banners.edit', $banner->id) }}"
                                        class="btn btn-outline-primary flex-fill rounded-3 fw-bold"
                                        style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                    <form action="{{ route('banners.destroy', $banner->id) }}" method="POST"
                                        class="flex-fill d-flex m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger w-100 rounded-3 delete-btn fw-bold"
                                            style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-images fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No banners found.</p>
                                <a href="{{ route('banners.create') }}" class="btn btn-outline-primary btn-sm mt-3">Create your
                                    first banner</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $banners->appends(request()->input())->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <style>
            .custom-table thead th {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                font-weight: 700;
                color: #64748b;
                padding: 1rem 0.75rem;
                border-bottom: 2px solid #e2e8f0;
            }

            .status-form {
                margin: 0;
            }

            .status-select {
                display: inline-block;
                width: 115px;
                padding: 5px 10px;
                font-size: 0.78rem;
                font-weight: 700;
                border-radius: 50px;
                cursor: pointer;
                outline: none !important;
                box-shadow: none !important;
                appearance: auto;
                -webkit-appearance: auto;
                transition: opacity 0.15s ease;
            }

            .status-select:hover {
                opacity: 0.82;
            }

            .status-active {
                background-color: #dcfce7;
                color: #15803d;
                border: 2px solid #86efac;
            }

            .status-inactive {
                background-color: #fee2e2;
                color: #b91c1c;
                border: 2px solid #fca5a5;
            }
        </style>

        <script>
            function updateBannerStatus(form) {
                let select = form.querySelector('select[name="is_active"]');

                // Update colors immediately
                if (select.value == '1') {
                    select.classList.remove('status-inactive');
                    select.classList.add('status-active');
                } else {
                    select.classList.remove('status-active');
                    select.classList.add('status-inactive');
                }

                // Submit via AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    // Silent update
                }).catch(error => {
                    console.error('Error updating banner status:', error);
                });
            }

            $(document).ready(function () {
                const containerSelector = '#bannerListContainer';

                function loadBanners(url) {
                    $(containerSelector).css('opacity', '0.5');
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (data) {
                            const newContent = $(data).find(containerSelector).html();
                            $(containerSelector).html(newContent);
                            $(containerSelector).css('opacity', '1');
                            window.history.pushState({}, '', url);
                        },
                        error: function () {
                            $(containerSelector).css('opacity', '1');
                            console.error('Failed to load banners.');
                        }
                    });
                }

                $(document).on('submit', '#bannerSearchForm', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('action') + '?' + $(this).serialize();
                    loadBanners(url);
                });

                $(document).on('click', '.pagination a', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    if (url) {
                        loadBanners(url);
                    }
                });

                $(document).on('click', '#resetBannerSearch', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    $('#bannerSearchForm input[name="search"]').val('');
                    loadBanners(url);
                });
            });
        </script>
@endsection