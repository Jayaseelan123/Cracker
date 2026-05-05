@extends('layouts.admin')

@section('header', 'Manage Banners')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Hero Banners</h2>
                    <p class="text-muted mb-0">Manage the hero banners displayed on the homepage</p>
                </div>
                <div>
                    <a href="{{ route('banners.create') }}" class="btn btn-primary shadow-sm rounded-3 px-4">
                        <i class="fas fa-plus me-2"></i>Add New Banner
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Preview</th>
                        <th>Title & Subtitle</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="rounded overflow-hidden shadow-sm" style="width: 120px; height: 60px; background: #f8fafc;">
                                <img src="{{ asset($banner->image) }}" alt="Banner" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $banner->title ?: 'No Title' }}</div>
                            <div class="text-muted small">{{ $banner->subtitle ?: 'No Subtitle' }}</div>
                        </td>
                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Active</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-sm btn-light text-primary rounded-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-3">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-images fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No banners found.</p>
                                <a href="{{ route('banners.create') }}" class="btn btn-outline-primary btn-sm mt-3">Create your first banner</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
</style>
@endsection
