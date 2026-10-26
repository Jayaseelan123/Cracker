@extends('layouts.admin')

@section('title', 'Manage Blog Posts')
@section('header', 'Blog Posts')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Blog Posts</h2>
                    <p class="text-muted mb-0">Manage your website's blog content</p>
                </div>
                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                    <form method="GET" action="{{ route('admin.blogs.index') }}" id="blogSearchForm" class="d-flex w-100 flex-grow-1 gap-2">
                        <input type="text" name="search" id="blogSearchInput"
                               class="form-control blog-search-input flex-grow-1"
                               placeholder="Search posts..."
                               value="{{ request('search') }}"
                               autocomplete="off" />
                        <button type="submit" class="btn btn-primary blog-search-btn px-3 text-nowrap">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn blog-reset-btn px-3 text-nowrap" title="Reset Search" id="blogResetBtn">
                            <i class="fas fa-sync-alt me-1"></i>Reset
                        </a>
                    </form>
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary shadow-sm px-4 blog-add-btn text-nowrap">
                        <i class="fas fa-plus me-2"></i>Create New Post
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(request('search'))
    <div class="alert border-0 rounded-3 mb-4 px-4 py-3 d-flex align-items-center justify-content-between"
         style="background:#eff6ff; border-left: 4px solid #0d6efd !important;">
        <div>
            <i class="fas fa-search me-2 text-primary"></i>
            <strong>{{ $blogs->total() }}</strong> result{{ $blogs->total() !== 1 ? 's' : '' }} found for
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 ms-1">&ldquo;{{ request('search') }}&rdquo;</span>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm blog-reset-btn">
            <i class="fas fa-times me-1"></i> Clear Search
        </a>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        @if($blogs->count() > 0)
        <!-- Desktop Table -->
        <div class="d-none d-md-block">
            <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">S.No</th>
                        <th>Title</th>
                        
                        <th>Status</th>
                        <th>Published</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">{{ $blogs->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ Str::limit($blog->title, 50) }}</div>
                            <span class="text-muted small">{{ $blog->created_at->format('M d, Y') }}</span>
                        </td>
                        
                        
                        <td>
                            @if($blog->is_published)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-3">Published</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle rounded-pill px-3">Draft</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '—' }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-outline-info d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="View">
                                    <i class="fas fa-eye" style="font-size: 1.1rem;"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="Edit">
                                    <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn" style="width: 38px; height: 38px;" title="Delete">
                                        <i class="fas fa-trash" style="font-size: 1.1rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>

        <!-- Mobile Cards -->
        <div class="d-block d-md-none p-3 bg-light">
            @foreach($blogs as $blog)
            <div class="card shadow-sm border-0 rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted fw-bold" style="font-size:0.85rem;">S.No: {{ $blogs->firstItem() + $loop->index }}</span>
                        @if($blog->is_published)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-3">Published</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle rounded-pill px-3">Draft</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="fw-bold text-dark fs-6">{{ Str::limit($blog->title, 60) }}</div>
                        <div class="text-muted small mt-1">Created: {{ $blog->created_at->format('M d, Y') }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Published Date</div>
                        <div class="fw-semibold text-dark">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '—' }}</div>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top mt-2 flex-wrap">
                        <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-outline-info flex-fill rounded-3 fw-bold" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-eye me-2"></i> View
                        </a>
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-primary flex-fill rounded-3 fw-bold" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="w-100 m-0 mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-3 delete-btn fw-bold" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-center">
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3 d-block"></i>
            <h4 class="text-dark">No Blog Posts Yet</h4>
            <p class="text-muted">Start creating engaging content for your audience</p>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mt-3 px-4">Create First Post</a>
        </div>
        @endif
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

    /* Search bar styles matching the image */
    .blog-search-input {
        width: 100%;
        max-width: 240px;
        border-radius: 8px !important;
        border: 1.5px solid #d1d5db;
        padding: 8px 14px;
        font-size: 0.88rem;
        color: #6b7280;
        box-shadow: none !important;
        transition: border-color 0.2s;
    }
    .blog-search-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1) !important;
    }

    .blog-search-btn {
        border-radius: 8px !important;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 8px 18px;
        background: #0d6efd;
        border: none;
        color: #fff;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .blog-search-btn:hover {
        background: #0b5ed7;
        box-shadow: 0 4px 12px rgba(13,110,253,0.3);
        color: #fff;
    }

    /* Teal outlined Reset button - exactly like image */
    .blog-reset-btn {
        border-radius: 8px !important;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 8px 18px;
        background: #fff;
        border: 1.5px solid #0dcaf0;
        color: #0dcaf0;
        transition: all 0.2s;
    }
    .blog-reset-btn:hover {
        background: #0dcaf0;
        color: #fff;
        box-shadow: 0 4px 12px rgba(13,202,240,0.3);
    }
    .blog-reset-btn .fa-sync-alt {
        color: inherit;
    }

    .blog-add-btn {
        border-radius: 8px !important;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 8px 18px;
        background: #0d6efd;
        border: none;
        color: #fff;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .blog-add-btn:hover {
        background: #0b5ed7;
        color: #fff;
        box-shadow: 0 4px 12px rgba(13,110,253,0.3);
    }
</style>

<script>
(function () {
    const input  = document.getElementById('blogSearchInput');
    const form   = document.getElementById('blogSearchForm');
    const reset  = document.getElementById('blogResetBtn');
    let timer;

    if (input) {
        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                form.submit();
            }, 400);
        });
    }

    // Allow Enter key to submit immediately
    if (input) {
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                clearTimeout(timer);
                form.submit();
            }
        });
    }
})();
</script>
@endsection
